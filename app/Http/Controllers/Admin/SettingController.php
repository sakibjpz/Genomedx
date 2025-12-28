<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $companies = Company::active()->ordered()->get();
        $selectedCompanyId = Setting::getValue('frontend_company_id');
        
        return view('admin.settings.index', compact('companies', 'selectedCompanyId'));
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'frontend_company_id' => 'nullable|exists:companies,id'
        ]);
        
        Setting::setValue('frontend_company_id', $request->frontend_company_id);
        
        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }
}