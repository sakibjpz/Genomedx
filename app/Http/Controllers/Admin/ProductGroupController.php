<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Company;

class ProductGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Load companies with product groups count for better display
        $groups = ProductGroup::with('company')->orderBy('position')->get();
        return view('admin.product-groups.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::active()->ordered()->get();
        return view('admin.product-groups.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'color'     => 'required|string|max:50',
            'icon'      => 'nullable|file|mimes:svg,png|max:2048',
            'position'  => 'nullable|integer',
            'status'    => 'nullable|boolean',
            'company_id' => 'nullable|exists:companies,id',
        ]);

        // Handle icon upload
        $iconPath = null;
        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $iconPath = $file->store('product-group-icons', 'public');
        }

        ProductGroup::create([
            'name'       => $request->name,
            'slug'       => Str::slug($request->name),
            'color'      => $request->color,
            'icon'       => $iconPath,
            'position'   => $request->position ?? 0,
            'status'     => $request->boolean('status'),
            'company_id' => $request->company_id, // Add this line
        ]);

        return redirect()
            ->route('admin.product-groups.index') // Fixed route name (added admin.)
            ->with('success', 'Product group created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
 public function edit(ProductGroup $productGroup)
{
    $companies = \App\Models\Company::active()->ordered()->get();
    return view('admin.product-groups.edit', compact('productGroup', 'companies'));
}
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductGroup $productGroup)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'color'     => 'required|string|max:50',
            'icon'      => 'nullable|file|mimes:svg,png|max:2048',
            'position'  => 'nullable|integer',
            'status'    => 'nullable|boolean',
            'company_id' => 'nullable|exists:companies,id', // Add validation
        ]);

        if ($request->hasFile('icon')) {
            if ($productGroup->icon && \Storage::disk('public')->exists($productGroup->icon)) {
                \Storage::disk('public')->delete($productGroup->icon);
            }
            $file = $request->file('icon');
            $productGroup->icon = $file->store('product-group-icons', 'public');
        }

        $productGroup->update([
            'name'       => $request->name,
            'color'      => $request->color,
            'slug'       => Str::slug($request->name),
            'position'   => $request->position ?? 0,
            'status'     => $request->boolean('status'),
            'company_id' => $request->company_id, // Add this line
        ]);

        // Return JSON for AJAX
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'group' => [
                    'name' => $productGroup->name,
                    'status' => $productGroup->status,
                    'colorHex' => $productGroup->colorHex(),
                ]
            ]);
        }

        return redirect()
            ->route('admin.product-groups.index') // Fixed route name
            ->with('success', 'Product group updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductGroup $productGroup)
    {
        // Delete icon if exists
        if ($productGroup->icon && \Storage::disk('public')->exists($productGroup->icon)) {
            \Storage::disk('public')->delete($productGroup->icon);
        }

        $productGroup->delete();

        // Return JSON response for AJAX
        return response()->json([
            'success' => true,
            'message' => 'Product group deleted successfully.'
        ]);
    }
}