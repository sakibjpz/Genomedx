<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductFeature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductFeatureController extends Controller
{
    /**
     * Show the form for creating a new feature for a product.
     */
    public function create(Product $product)
    {
      return view('admin.products.features.create-edit', compact('product'));
    }

    /**
     * Store a newly created feature in storage.
     */
    public function store(Request $request, Product $product)
    {
       $validated = $request->validate([
    'title' => 'required|string|max:255',
    'description' => 'nullable|string',
    'icon' => 'nullable|string|max:100',
    'color' => 'nullable|string|max:7',
    'sort_order' => 'integer|min:0',
    'is_active' => 'boolean',
    'download_label' => 'nullable|string|max:100',
    'download_file' => 'nullable|file|mimes:pdf|max:5120',
]);

// Handle file upload
if ($request->hasFile('download_file')) {
    $file = $request->file('download_file');
    $fileName = 'feature_' . time() . '_' . $file->getClientOriginalName();
    $filePath = $file->storeAs('feature_documents', $fileName, 'public');
     $validated['download_link'] = $filePath;
}

        $product->features()->create($validated);

        return redirect()->route('admin.product-groups.products.edit', [$product->productGroup, $product->id])
            ->with('success', 'Feature added successfully.');
    }

    /**
     * Show the form for editing the specified feature.
     */
    public function edit(Product $product, ProductFeature $feature)
    {
       return view('admin.products.features.create-edit', compact('product', 'feature'));
    }

    /**
     * Update the specified feature in storage.
     */
   

   public function update(Request $request, Product $product, ProductFeature $feature)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'icon' => 'nullable|string|max:100',
        'color' => 'nullable|string|max:7',
        'sort_order' => 'integer|min:0',
        'is_active' => 'boolean',
        'download_label' => 'nullable|string|max:100',
        'download_file' => 'nullable|file|mimes:pdf|max:5120',
    ]);

    // Handle file upload - THIS IS THE KEY PART
    if ($request->hasFile('download_file')) {
        // Delete old file if exists
        if ($feature->download_link && Storage::disk('public')->exists($feature->download_link)) {
            Storage::disk('public')->delete($feature->download_link);
        }
        
        $file = $request->file('download_file');
        $fileName = 'feature_' . time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('feature_documents', $fileName, 'public');
        
        // ADD the file path to validated array as 'download_link'
        $validated['download_link'] = $filePath;
        
        // REMOVE 'download_file' from validated array (it's not a database column)
        unset($validated['download_file']);
    }

    $feature->update($validated);

    return redirect()->route('admin.product-groups.products.edit', [$product->productGroup, $product->id])
        ->with('success', 'Feature updated successfully.');
}
    /**
     * Remove the specified feature from storage.
     */
    public function destroy(Product $product, ProductFeature $feature)
    {
        $feature->delete();

        return redirect()->route('admin.products.edit', $product->id)
            ->with('success', 'Feature deleted successfully.');
    }
}