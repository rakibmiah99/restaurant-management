<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Http\Requests\CompanySettingsRequest;
use App\Models\CompanySetting;
use Illuminate\Http\Request;

class CompanySettingsController extends Controller
{
    public function companySettings()
    {
        $settings = CompanySetting::first();
        return view('company_settings', compact('settings'));
    }

    public function companySettingsUpdate(CompanySettingsRequest $request)
    {
        try {
            $settings = CompanySetting::first();
            $data = collect($request->validated())->except('file')->toArray();
            if ($request->file){
                $settings->clearMediaCollection();
                $settings->addMediaFromRequest('file')->toMediaCollection();
            }
            if ($settings){
                $settings->update($data);;
            }
            else{
                CompanySetting::create($data);
            }

            return $this->successMessage(Helper::UpdatedSuccessFully());
        }
        catch (\Exception $exception){
            return $this->errorMessage($exception->getMessage());
        }

    }
}
