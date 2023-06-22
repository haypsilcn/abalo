<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

/**
 * Write static login information to the session.
 * Use for test purposes.
 */
class AuthController extends Controller
{
    public function login(Request $request) {
        /*$request->session()->put('abalo_user', 'visitor');
        $request->session()->put('abalo_mail', 'visitor@abalo.example.com');
        $request->session()->put('abalo_time', time());
        return redirect()->route('haslogin');*/
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
//        $request->session()->flush();
        Session::flush();
        return redirect('login');

//        return redirect()->route('haslogin');
    }


    /*public function isLoggedIn(Request $request) {
        if($request->session()->has('abalo_user')) {
            $r["user"] = $request->session()->get('abalo_user');
            $r["time"] = $request->session()->get('abalo_time');
            $r["mail"] = $request->session()->get('abalo_mail');
            $r["auth"] = "true";
        }
        else
            $r["auth"]="false";

        return response()->json($r);
    }*/

    public function isLoggedIn(Request $request) {
        $user["name"] = Session::get("user");
        $user["email"] = Session::get("mail");
//        dd($user);
        if (Session::has("user")) {
            $user["name"] = Session::get("user");
            $user["email"] = Session::get("mail");
            $user["auth"] = "true";
        } else
            $user["auth"] = "false";

        return response()->json($user);
    }
}
