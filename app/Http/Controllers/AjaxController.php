<?php

namespace App\Http\Controllers;

use App\Models\Cluster;
use App\Models\Site;
use App\Models\User;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function searchUser($searchTerm) {

        $return = [];
        $searchTerm = trim($searchTerm);

        if(strlen($searchTerm) > 0) {
            $users = User::where('first_name', 'LIKE', "%$searchTerm%")
                        ->orWhere('email', 'LIKE', "%$searchTerm%")
                        ->get();
            foreach($users as $user) {
                $return[] = (object) [
                    'id' => $user->id,
                    'last_name' => $user->last_name,
                    'first_name' => $user->first_name,
                    'email' => $user->email,
                ];
            }
        }
        return response()->json($return);
    }
}
