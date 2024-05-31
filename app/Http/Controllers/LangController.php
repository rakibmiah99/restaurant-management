<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\App;

class LangController extends Controller
{
    function change($lang){
        \request()->session()->put('lang', $lang);
        return redirect()->back();
    }
}
