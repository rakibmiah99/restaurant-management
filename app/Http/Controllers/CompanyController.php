<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CategoryCreateRequest;
use App\Models\Company;
use App\Models\Country;
use App\Models\MealPrice;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request){
        $data = Company::where('name', 'like', '%'.$request->q."%")->paginate((int)$request->perpage ?? 10)->withQueryString();
        return view('company.index', compact('data'));
    }

    public function show($id){
        $company =  Company::find($id);
        if (!$company){
            abort(404);
        }
        return response()->json($company);
    }

    public function create(Request $request){
        $countries = Country::get();
        $meal_prices = MealPrice::active()->get();
        return view('company.create', compact('countries', 'meal_prices'));
    }

    public function store(CategoryCreateRequest $request){
        try {
            Company::create($request->validated());
            return redirect()->back()->with('success', 'Company Created Successfully');
        }
        catch (\Exception $exception){
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }


    public function delete($id){
        $company =  Company::find($id);
        if (!$company){
            abort(404);
        }
        $company->delete();

        return redirect()->back()->with('success', "Company Deleted Successfully");
    }

    public function changeStatus($id){
        $company =  Company::find($id);
        if (!$company){
            abort(404);
        }

        $company->status = !$company->status;
        $company->save();
        return redirect()->back()->with('success', "status successfully updated");
    }
}
