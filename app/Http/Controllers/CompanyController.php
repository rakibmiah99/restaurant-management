<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request){
        $data = Company::where('name', 'like', '%'.$request->q."%")->paginate((int)$request->perpage ?? 10)->withQueryString();
        return view('company.index', compact('data'));
    }
}
