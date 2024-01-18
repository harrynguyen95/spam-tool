<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __contruct()
    {
        $this->middleware('auth', ['except' => ['logout']]);
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required|min:6',
        ]);

        if (Auth::guard('web')->attempt(['username' => $request->username, 'password' => $request->password], $request->remember)) {

            return redirect()->route('dashboard')
                ->withSuccess(t('Login success.'))
                ->cookie('suggest_lang_code', auth()->user()->lang_code, '10080');
        }
        return redirect()->back()->withInput($request->only('username', 'remember'))->withErrors(['error' => t('Incorrect username or password.')]);
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('login');
    }

}
