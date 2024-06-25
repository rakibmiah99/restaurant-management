<?php

namespace App\Http\Controllers;

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
            if ($settings){
                $settings->update($request->validated());;
            }
            else{
                CompanySetting::create($request->validated());
            }

            return $this->successMessage('updated successfully');
        }
        catch (\Exception $exception){
            return $this->errorMessage($exception->getMessage());
        }

    }
}
