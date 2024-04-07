<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function index(): View
    {
        return view('backend.auth.login');
    }

    public function postLogin(Request $req)
    {
        $req->validate([
            'user_name' => 'required',
            'password' => 'required'
        ]);

        /* $user = array(
            'user_name' => $req->user_name,
            'password' => $req->password
        ); */

        // This code it check with auth if auth not found then it will return error
        $user = $req->only('user_name', 'password');
        if (Auth::attempt($user)) {
            return redirect()->intended('/')->with('success', 'Login successfully');
        }
        return redirect('login')->with('error', 'Failed to logined!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }
}
