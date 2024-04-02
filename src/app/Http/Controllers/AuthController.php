<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function getRegister()
    {
        return view('register');
    }

    public function postRegister(RegisterRequest $request)
    {
        $validator = $request->validated();
    
        try {
            User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);

            return redirect()->route('thanks');
        } catch (\Throwable $th) {
            return redirect('register')->with('result', 'エラーが発生しました');
        }
    }

    public function getLogin()
    {
        return view('login');
    }

    public function postLogin(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            return redirect('/')->with('success', 'ログインに成功しました');
        } else {
            return redirect('login')->with('error', 'メールアドレスまたはパスワードが間違っています');
        }
    }

    public function getLogout()
    {
        Auth::logout();
        return redirect("login")->with('success', 'ログアウトしました');
    }
}
