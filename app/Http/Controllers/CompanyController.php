<?php

namespace App\Http\Controllers;

use App\Exports\CompanyExport;
use App\Http\Requests\Category\CategoryCreateRequest;
use App\Models\Company;
use App\Models\Country;
use App\Models\MealPrice;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CompanyController extends Controller
{
    public function index(Request $request){
//        return $request->only(['q', 'columns']);
        $columns = (new Company())->getColumns();
        $data = Company::filter()->paginate((int)$request->perpage ?? 10)->withQueryString();
        return view('company.index', compact('data', 'columns'));
    }

    public function show($id){
        $company =  Company::find($id);
        if (!$company){
            abort(500, 'ff');
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


    //for export to pdf and Excel file
    public function export(Request $request){
        if ($request->get('export-type') == "excel"){
            return Excel::download(new CompanyExport(), 'company.xlsx');
        }
        else if($request->get('export-type') == "pdf"){
            return Excel::download(new CompanyExport(), 'company.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
        }

    }
}
