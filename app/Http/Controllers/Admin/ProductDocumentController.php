<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductDocumentController extends Controller
{
    /**
     * Display a listing of documents for a product.
     */
    public function index(Product $product)
    {
        $documents = $product->documents()->orderBy('category')->orderBy('sort_order')->get();
        $categories = ['product_leaflet' => 'Product Leaflet', 'eqa_results' => 'EQA Results', 'documentation' => 'Documentation'];
        
        return view('admin.products.documents.index', compact('product', 'documents', 'categories'));
    }

    /**
     * Show the form for creating a new document.
     */
    public function create(Product $product)
    {
        $categories = ['product_leaflet' => 'Product Leaflet', 'eqa_results' => 'EQA Results', 'documentation' => 'Documentation'];
        return view('admin.products.documents.create', compact('product', 'categories'));
    }

    /**
     * Store a newly created document in storage.
     */
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category' => 'required|string|in:product_leaflet,eqa_results,documentation',
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf|max:10240', // 10MB max
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Handle file upload
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('product_documents', $fileName, 'public');
        
        $product->documents()->create([
            'category' => $validated['category'],
            'title' => $validated['title'],
            'file_path' => $filePath,
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'file_type' => 'pdf',
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.products.documents.index', $product->id)
            ->with('success', 'Document uploaded successfully.');
    }

    /**
     * Show the form for editing the specified document.
     */
    public function edit(Product $product, ProductDocument $document)
    {
        $categories = ['product_leaflet' => 'Product Leaflet', 'eqa_results' => 'EQA Results', 'documentation' => 'Documentation'];
        return view('admin.products.documents.edit', compact('product', 'document', 'categories'));
    }

    /**
     * Update the specified document in storage.
     */
    public function update(Request $request, Product $product, ProductDocument $document)
    {
        $validated = $request->validate([
            'category' => 'required|string|in:product_leaflet,eqa_results,documentation',
            'title' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf|max:10240',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Handle file upload if new file provided
        if ($request->hasFile('file')) {
            // Delete old file
            if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }
            
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('product_documents', $fileName, 'public');
            
            $validated['file_path'] = $filePath;
            $validated['file_name'] = $file->getClientOriginalName();
            $validated['file_size'] = $file->getSize();
        }

        $document->update($validated);

        return redirect()->route('admin.products.documents.index', $product->id)
            ->with('success', 'Document updated successfully.');
    }

    /**
     * Remove the specified document from storage.
     */
    public function destroy(Product $product, ProductDocument $document)
    {
        // Delete file from storage
        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }
        
        $document->delete();

        return redirect()->route('admin.products.documents.index', $product->id)
            ->with('success', 'Document deleted successfully.');
    }
}