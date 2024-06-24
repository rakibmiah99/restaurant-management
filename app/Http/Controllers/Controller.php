<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function successMessage($message){
        return redirect()->back()->with('success', $message);
    }
    public function errorMessage($message){
        return redirect()->back()->with('error', $message)->withInput(request()->all());
    }
}
