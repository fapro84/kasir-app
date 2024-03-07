<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index() {
        return view('login.index');
    }

    public function login(Request $request) {

        $request-> validate([
            'username' => 'required',
            'password' => 'required'
        ],[
            'username.required' => 'username harus diisi',
            'password.required' => 'password harus diisi'
        ]);

        $credentials = $request->only('username', 'password');

        if(Auth::attempt($credentials)){
            $user = Auth::user();
            session(['user' => $user]);
            // $request->authenticate();
            $request->session()->regenerate();
            
            return redirect('dash');
        } else{
            return redirect('')->withErrors('username dan password yang dimasukkan salah')->withInput();
        }
    }


    public function logout(Request $request) {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    
}