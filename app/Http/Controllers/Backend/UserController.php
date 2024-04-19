<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $data['userList'] = User::orderBy('id', 'desc')
            ->paginate(config('app.row'));
        return view('backend.user.index', $data);
    }

    public function resetPassword(Request $req)
    {


        $req->validate([
            'password' => 'required|min:6',
            'confirmPassword' => 'required|same:password',
        ], [
            'password.required' => 'សូមបញ្ចូលលេខសម្ងាត់',
            'password.min' => 'លេខសម្ងាត់ត្រូវមានយ៉ាងហោចណាស់ 6 ខ្ទង់',
            'confirmPassword.required' => 'សូមបញ្ចូលលេខសម្ងាត់ដើម្បីបញ្ជាក់',
            'confirmPassword.same' => 'លេខសម្ងាត់មិនដូចគ្នាទេ',
        ]);

        $data['user'] = User::find($req->user_id);
        $data['user']->password = bcrypt($req->password);
        $data['user']->save();
        return back()->with('success', 'លេខសម្ងាត់ត្រូវបានប្ដូរជោគជ័យ');
    }
}
