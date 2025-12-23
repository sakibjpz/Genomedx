<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductDetailController extends Controller
{
    /**
     * Show the form for editing the specified product's details.
     */
    public function edit($productId)
    {
        $product = Product::findOrFail($productId);

        // Ensure product detail exists
        $detail = $product->details;
        if (!$detail) {
            $detail = new ProductDetail();
            $detail->product_id = $product->id;
            $detail->save();
        }

        return view('admin.products.details.edit', compact('product', 'detail'));
    }

    /**
     * Update the specified product's details in storage.
     */
  public function update(Request $request, $productId)
{
    $product = Product::findOrFail($productId);

    // Get or create ProductDetail
    $detail = $product->details ?? new ProductDetail(['product_id' => $product->id]);

    // Save description
    $detail->description = $request->input('description');

    // Save specifications (one per line from textarea)
    $specs = $request->input('specifications');
    $specArray = $specs ? array_filter(array_map('trim', explode("\n", $specs))) : null;
    $detail->specifications = $specArray ? json_encode($specArray) : null;

    // Save order table (JSON)
$orderTable = $request->input('order_table');
if ($orderTable) {
    $rows = array_filter(array_map('trim', explode("\n", $orderTable)));
    $orderArray = [];
    
    foreach ($rows as $row) {
        $columns = array_map('trim', explode('|', $row));
        if (count($columns) >= 4) {
            $orderArray[] = [
                'name' => $columns[0] ?? '',
                'ref' => $columns[1] ?? '',
                'technology' => $columns[2] ?? '',
                'packaging' => $columns[3] ?? '',
            ];
        }
    }
    
    $detail->order_table = !empty($orderArray) ? json_encode($orderArray) : null;
} else {
    $detail->order_table = null;
}

    // Handle IMAGE upload
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('product_details', $fileName, 'public');

        // Delete old image if exists
        if ($detail->image) {
            Storage::disk('public')->delete($detail->image);
        }

        $detail->image = 'product_details/' . $fileName;
    }

    // Handle SECOND IMAGE upload
if ($request->hasFile('second_image')) {
    $file = $request->file('second_image');
    $fileName = time() . '_second_' . $file->getClientOriginalName();
    $file->storeAs('product_details', $fileName, 'public');

    // Delete old second image if exists
    if ($detail->second_image) {
        Storage::disk('public')->delete($detail->second_image);
    }

    $detail->second_image = 'product_details/' . $fileName;
}

    // Handle brochure upload
    if ($request->hasFile('brochure')) {
        $file = $request->file('brochure');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('product_details', $fileName, 'public');

        // Delete old brochure if exists
        if ($detail->brochure) {
            Storage::disk('public')->delete($detail->brochure);
        }

        $detail->brochure = 'product_details/' . $fileName;
    }

    // Save SEO fields
    $detail->meta_title = $request->input('meta_title');
    $detail->meta_description = $request->input('meta_description');

    $detail->save();

    return redirect()->back()->with('success', 'Product details updated successfully.');
}
}