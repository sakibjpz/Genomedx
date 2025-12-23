<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display all products of a company
     */
    public function show(Company $company)
    {
        return view('companies.show', compact('company'));
    }
}