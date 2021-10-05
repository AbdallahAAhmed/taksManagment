<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        // this code made by erjwan ...
        $request->validate(
            [
                'username' => 'required',
                'password' => 'required',
            ],
        );

        $credentials = $request->only('username', 'password');

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'message' => 'User or Password is Wrong !'
            ]);
        }
        return redirect()->route('home.index');
    }

    public function showLogin()
    {
        return view('frontend.login');
    }



    public function logout()
    {
        auth()->logout();
        return redirect('/')->with('success', 'You have been logged out');
    }
}
