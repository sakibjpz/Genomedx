<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductGroup;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of products for a group.
     */
    public function index(ProductGroup $productGroup)
    {
        // Get all products for this group ordered by position
        $products = $productGroup->products()->orderBy('position')->get();

        return view('admin.products.index', compact('productGroup', 'products'));
    }

    public function create(ProductGroup $productGroup)
{
    // Pass the product group to the view
    return view('admin.products.create', compact('productGroup'));
}

    /**
     * Show the form for editing the specified product.
     */
   public function edit(ProductGroup $product_group, Product $product)
{
    // Eager load features, details, and other relations
    $product->load(['features', 'details', 'documents']);
    $productGroups = ProductGroup::all();
    
    return view('admin.products.edit', compact('product', 'productGroups', 'product_group'));
}
    /**
     * Update the specified product in storage.
     */
  public function update(Request $request, ProductGroup $productGroup, Product $product)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'product_group_id' => 'required|exists:product_groups,id',
        // other validation rules
    ]);
    
    // Check if group is being changed
    $newGroupId = $request->product_group_id;
    
    // Update product with new group if changed
    $product->update([
        'name' => $request->name,
        'product_group_id' => $newGroupId, // This allows changing groups
        'short_description' => $request->short_description,
        'position' => $request->position,
        'status' => $request->boolean('status'),
        'badge' => $request->badge,
        'certifications' => $request->certifications,
    ]);
    
    // Handle image upload if provided
    if ($request->hasFile('image')) {
        // Delete old image
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        // Upload new image
        $imagePath = $request->file('image')->store('products', 'public');
        $product->update(['image' => $imagePath]);
    }
    
    // Redirect based on new group
    $newGroup = ProductGroup::find($newGroupId);
    
    return redirect()->route('admin.product-groups.products.index', $newGroup)
                    ->with('success', 'Product updated successfully');
}
    /**
     * Remove the specified product from storage.
     */
public function destroy(ProductGroup $productGroup, Product $product)
    {
        // Delete image if exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Delete product
        $product->delete();

        return redirect()
            ->back()
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Store a newly created product.
     */
  public function store(Request $request, ProductGroup $productGroup)
{
    // Validate input
    $request->validate([
        'name'              => 'required|string|max:255',
        'short_description' => 'nullable|string',
        'image'             => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
        'position'          => 'nullable|integer',
        'status'            => 'nullable|boolean',
        'badge'             => 'nullable|string|max:50',
    ]);

    // Handle image upload
    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('products', 'public');
    }

    // === ADD THIS SECTION ===
    // Generate unique slug
    $slug = Str::slug($request->name);
    $originalSlug = $slug;
    $counter = 1;

    // Check if slug exists and make it unique
    while (Product::where('slug', $slug)->exists()) {
        $slug = $originalSlug . '-' . $counter;
        $counter++;
    }
    // === END ADDED SECTION ===

    // Create product
    $productGroup->products()->create([
        'name'              => $request->name,
        'slug'              => $slug,  // Changed from Str::slug($request->name)
        'short_description' => $request->short_description,
        'image'             => $imagePath,
        'position'          => $request->position ?? 0,
        'status'            => $request->boolean('status'),
        'badge'             => $request->badge,
    ]);

   return redirect()
    ->route('admin.product-groups.products.index', $productGroup)
    ->with('success', 'Product added successfully.');
}
    public function byGroup()
    {
        // Fetch all product groups with their products
        $groups = ProductGroup::with(['products' => function($query) {
            $query->orderBy('position');
        }])->get();

        // Pass to view
        return view('admin.products.by-group', compact('groups'));
    }
    
}