<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserSettingsRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserSettingsController extends Controller
{
    public function show()
    {
        return view('UserSettings.form');
    }

    public function update(UserSettingsRequest $request)
    {
        DB::beginTransaction();

        try {
            $user = User::find(Auth::user()->id);
            $user->settings($request->validated());
        } catch (\Throwable $e){
            DB::rollBack();
            return redirect()->back()->with('error', trans('texts.transactionerror'));
        }

        DB::commit();

        session(['lang' => $user->setting('lang')]);

        return redirect()->route('home')->with('success', trans('pages/usersettings.messages.updatesuccess'));
    }

    public function changeLang($lang) {
        if(in_array($lang, ['fr', 'en'])) {
            $user = User::find(Auth::user()->id);
            if($user) {
                $user->settings(['lang' => $lang], true);
                session(['lang' => $user->setting('lang')]);
            }
        }
        return redirect()->back();
    }
}
