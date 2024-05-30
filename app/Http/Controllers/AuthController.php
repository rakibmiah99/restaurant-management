<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginPage(){
        return view('auth.login');
    }

    public function login(LoginRequest $request){
        $credential = $request->only(['email', 'password']);
        if(Auth::attempt($credential)){

        }
        else{
            return redirect()
                ->back()
                ->withErrors(['message' => 'email or password doesn\'t match try again'])
                ->withInput($request->all());
        }

    }
}
