<?php

namespace App\Http\Controllers;

use App\Enums\ExportFormat;
use App\Helper;
use App\Http\Requests\Company\CompanyCreateRequest;
use App\Http\Requests\Company\CompanyUpdateRequest;
use App\Models\Company;
use App\Models\Country;
use App\Models\MealPrice;
use App\Services\CompanyService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->group_name = 'company';
    }

    public function index(Request $request){
        Helper::HasPermissionView($this->group_name);
        $columns = (new Company())->getColumns();
        $data = Company::filter()->paginate(Helper::PerPage())->withQueryString();
        return view('company.index', compact('data', 'columns'));
    }

    public function show($id){
        $company =  Company::find($id);
        if (!$company){
            abort(500, 'ff');
        }
        return response()->json($company);
    }

    public function create(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $countries = Country::get();
        $meal_prices = MealPrice::active()->get();
        return view('company.create', compact('countries', 'meal_prices'));
    }

    public function edit($id, Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $company = Company::find($id);
        if (!$company){
            abort(404);
        }
        $countries = Country::get();
        $meal_prices = MealPrice::active()->get();
        return view('company.edit', compact('countries', 'meal_prices', 'company'));
    }


    public function store(CompanyCreateRequest $request){
        try {
            Company::create($request->validated());
            return redirect()->back()->with('success', Helper::CreatedSuccessFully());
        }
        catch (\Exception $exception){
            return redirect()->back()->with('error', $exception->getMessage())->withInput($request->all());
        }
    }


    public function update($id, CompanyUpdateRequest $request){
        $company = Company::find($id);
        if (!$company){
            abort(404);
        }
        $company->update($request->validated());
        return redirect()->back()->with('success', Helper::UpdatedSuccessFully());
    }


    public function delete(CompanyService $companyService){
        try {
            if ($companyService->canDelete()){
                return redirect()->back()->with('success', Helper::DeletedSuccessFully());
            }
            else{
                return $this->errorMessage(Helper::CantDeleteUsedInAnother());
            }
        }
        catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    public function changeStatus($id){
        $company =  Company::find($id);
        if (!$company){
            abort(404);
        }

        $company->status = !$company->status;
        $company->save();
        return redirect()->back()->with('success', Helper::StatusChangedSuccessFully());
    }


    //for export to pdf and Excel file
    public function export(Request $request){
        if ($request->get('export-type') == "excel"){
            return Excel::download(new \App\Exports\PDF\CompanyExport(), Helper::GenerateFileName('company', ExportFormat::XLSX->value));
        }
        else if($request->get('export-type') == "pdf"){
            return Excel::download(new \App\Exports\PDF\CompanyExport(), Helper::GenerateFileName('company', ExportFormat::PDF->value), \Maatwebsite\Excel\Excel::DOMPDF);
        }
    }
}
