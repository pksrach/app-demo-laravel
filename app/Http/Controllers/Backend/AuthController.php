<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
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
        // $user = $req->only('user_name', 'password');
        if (Auth::attempt(['user_name' => $req->user_name, 'password' => $req->password, 'active' => 1])) {
            return redirect()->intended('/')->with('success', 'Login successfully');
        }
        return redirect('login')->with('error', 'Failed to logined!');
    }

    public function registration()
    {
        return view('backend.auth.register');
    }

    public function postRegistration(Request $req)
    {
        $req->validate([
            'name' => 'required|unique:users',
            'user_name' => 'required|unique:users',
            'password' => 'required|unique:users',
            'email' => 'required|unique:users|email'
        ]);

        $data = $req->all();
        User::create([
            'name' => $data['name'],
            'user_name' => $data['user_name'],
            'password' => bcrypt($data['password']),
            'email' => $data['email'],
            'active' => 1,
            'language' => $data['language']
        ]);

        return redirect('register')->with('success', 'Register successfully');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }
}
