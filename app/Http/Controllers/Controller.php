<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function successMessage($message, $route = null): \Illuminate\Http\RedirectResponse
    {
        if ($route){
            return redirect()->route($route)->with('success', $message);
        }
        else{
            return redirect()->back()->with('success', $message);
        }

    }
    public function errorMessage($message, $route = null): \Illuminate\Http\RedirectResponse
    {
        if ($route){
            return redirect()->route($route)->with('error', $message);
        }
        else {
            return redirect()->back()->with('error', $message)->withInput(request()->all());
        }
    }
}
