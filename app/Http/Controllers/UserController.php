<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\Site;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::orderBy('first_name')->paginate(config('orpea.paginationCount'));
        return view('users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new User.
     *
     * @return Response
     */
    public function create()
    {
        return view('users.form', [
            'action' => 'create',
            'roles' => Role::all()->pluck('name', 'id')
        ]);
    }

    /**
     * Store a newly created User in storage.
     *
     * @return Response
     */
    public function store(UserCreateRequest $request)
    {
        if (count($request->get('roles')) == 0) {
            return redirect()->back()->with('error', "Merci de sélectionner au moins un role");
        }

        DB::beginTransaction();

        try {
            $user = User::create(
                array_merge(
                    $request->validated(),
                    [
                        'password' => bcrypt($request->validated()['email']),
                    ]
                )
            );

            foreach($request->get('roles') as $role) {
                $user->assignRole($role);
            }
            $user->sites()->attach($request->get('sites'));
        } catch (\Throwable $e){
            DB::rollBack();
            return redirect()->back()->with('error', trans('texts.transactionerror'));
        }

        DB::commit();

        if ($request->has('newform')) {
            return redirect()->route('user.create')->with('success', trans('pages/user.messages.createsuccess'));
        } else {
            return redirect()->route('user.index')->with('success', trans('pages/user.messages.createsuccess'));
        }
     }

    /**
     * Show the form for editing the specified User.
     *
     * @param  int  $user
     * @return Response
     */
    public function edit(User $user)
    {
        return view('users.form', [
            'action' => 'update',
            'user' => $user,
            'roles' => Role::all()->pluck('name', 'id')
        ]);
    }

    /**
     * Update the specified User in storage.
     *
     * @param  int  $user
     * @return Response
     */
    public function update(UserRequest $request, User $user)
    {
        DB::beginTransaction();

        try {
            $user->update($request->validated());
            $user->sites()->sync($request->get('sites'));
            $user->syncRoles($request->get('roles'));
        } catch (\Throwable $e){
            DB::rollBack();
            return redirect()->back()->with('error', trans('texts.transactionerror'));
        }

        DB::commit();

        if ($request->has('newform')) {
            return redirect()->route('user.create')->with('success', trans('pages/user.messages.updatesuccess'));
        } else {
            return redirect()->route('user.index')->with('success', trans('pages/user.messages.updatesuccess'));
        }
    }

    public function changePassword(Request $request) {
        $userId = $request->get('userId');
        $newPwd = $request->get('newpwd');
        if ((int) $userId > 0) {
            if ($userId != Auth::user()->id && !Auth::user()->hasRole('admin')) {
                return redirect()->back()->with('error', trans('labels.unknowerror'));
            }
            $user = User::find($userId);
            if (!$user) {
                return redirect()->back()->with('error', trans('labels.unknowerror'));
            }
            $user->password = bcrypt($newPwd);
            $user->save();

            return redirect()->back()->with('success', trans('labels.pwdchanged'));
        }
        return redirect()->back()->with('error', trans('labels.unknowerror'));
    }
}
