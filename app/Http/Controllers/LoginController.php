<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('user.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt([
            'name' => $request->name,
            'password' => $request->password
        ])) {

            $request->session()->regenerate();

            $user = Auth::user();

            // ADMIN
            if ($user->role_id == 1) {
                return redirect('/adm');
            }

            // USER
            return redirect('/');
        }

        // LOGIN FAIL → quay lại form login + giữ input
        return back()
            ->withInput()
            ->with('error', 'Sai tài khoản hoặc mật khẩu');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/dangnhap');
    }
}