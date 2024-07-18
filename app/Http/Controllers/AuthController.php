<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Lang;

class AuthController extends Controller
{
    public function loginPage(){
        return view('auth.login');
    }

    public function login(LoginRequest $request){
        $credential = $request->only(['email', 'password']);
        if(Auth::attempt($credential, true)){
            if ($request->remember){
                $minutes = 3 * 24 * 60;
                Cookie::queue('remember_email', $credential['email'], $minutes);
                Cookie::queue('remember_password', Crypt::encrypt($credential['password']), $minutes);
                Cookie::queue('remember', $request->remember, $minutes);
            }
            else{
                Cookie::queue(Cookie::forget('remember_email'));
                Cookie::queue(Cookie::forget('remember_password'));
                Cookie::queue(Cookie::forget('remember'));
            }
            return redirect()->route('home');
        }
        else{
            return redirect()
                ->back()
                ->withErrors(['message' => 'email or password doesn\'t match try again'])
                ->withInput($request->all());
        }

    }

    public function logout(){
        Auth::logout();
        return redirect()->route('loginPage');
    }
}
