<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

/**
 * Write static login information to the session.
 * Use for test purposes.
 */
class AuthController extends Controller
{
    public function login(Request $request) {
        $username = trim($request->input('username'));
        $password = $request->input('password');
        $user = User::where("name", $username)->where("password", $password)->first();

        if ($user) {
            Session::put("user", $username);
            Session::put("mail", $user->email);
            Session::put("auth", "true");
            $user->cart()->create();
            return view('homepage');
        } else
            return view("login", [
                "username" => $username,
                "password" => $password,
                "error" => "Incorrect username or password"
            ]);

    }

    public function logout() {
        Session::flush();
        return redirect('login');
    }

    public function isLoggedIn() {
        $user["name"] = Session::get("user");
        $user["email"] = Session::get("mail");
        if (Session::has("user")) {
            $user["name"] = Session::get("user");
            $user["email"] = Session::get("mail");
            $user["auth"] = "true";
        } else
            $user["auth"] = "false";

        return response()->json($user);
    }
}
