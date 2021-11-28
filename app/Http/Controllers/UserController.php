<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * This is the UserController class.
 * It powers all of the API routes related to management of users.
 * This includes, but is not limited to updating and fetching users.
 */
class UserController
{
    public function get(Request $request) {
        return $request->user();
    }

    public function saveSavefile(Request $request) {
        $user = $request->user();
        $user->savefile = $request->savefile;
        $user->save();

        if ($user->savefile === $request->savefile) {
            return response()->json(['success' => true, 'user' => $user->toArray()]);
        } else {
            return response()->json(['success' => false, 'user' => $user->toArray()]);
        }
    }
}
