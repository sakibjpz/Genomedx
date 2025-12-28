<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of companies.
     */
    public function index()
    {
        $companies = Company::ordered()->paginate(20);
        return view('admin.companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new company.
     */
    public function create()
    {
        return view('admin.companies.create');
    }

    /**
     * Store a newly created company.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:companies',
            'slug' => 'required|string|max:255|unique:companies',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Added
        ]);

        $data = [
            'name' => $request->name,
            'slug' => $request->slug,
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $request->sort_order ?? 0
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('company-images', 'public');
        }

        Company::create($data);

        return redirect()->route('admin.companies.index')
            ->with('success', 'Company created successfully.');
    }

    /**
     * Show the form for editing a company.
     */
    public function edit(Company $company)
    {
        return view('admin.companies.edit', compact('company'));
    }

    /**
     * Update the specified company.
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:companies,name,' . $company->id,
            'slug' => 'required|string|max:255|unique:companies,slug,' . $company->id,
            'is_active' => 'boolean',
            'sort_order' => 'integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Added
        ]);

        $data = [
            'name' => $request->name,
            'slug' => $request->slug,
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $request->sort_order ?? $company->sort_order
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('company-images', 'public');
        }

        $company->update($data);

        return redirect()->route('admin.companies.index')
            ->with('success', 'Company updated successfully.');
    }

    /**
     * Remove the specified company.
     */
    public function destroy(Company $company)
    {
        // Check if company has product groups
        if ($company->productGroups()->count() > 0) {
            return back()->with('error', 'Cannot delete company that has product groups.');
        }

        $company->delete();

        return redirect()->route('admin.companies.index')
            ->with('success', 'Company deleted successfully.');
    }

    /**
     * Update sort order.
     */
    public function reorder(Request $request)
    {
        foreach ($request->order as $index => $id) {
            Company::where('id', $id)->update(['sort_order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}