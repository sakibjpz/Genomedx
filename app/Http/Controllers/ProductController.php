<?php

namespace App\Http\Controllers;

use App\Models\ProductGroup;
use App\Models\Product;
use App\Models\SocialLink; 
use App\Models\Flag;
use App\Models\Menu;
use Illuminate\Http\Request;



class ProductController extends Controller
{
    /**
     * Show all products under a product group.
     */
    public function index($groupSlug)
    {
        $productGroup = ProductGroup::where('slug', $groupSlug)->firstOrFail();

        $products = $productGroup->products()
                    ->where('status', 1)
                    ->orderBy('position')
                    ->get();

        $socialLinks = SocialLink::all();
        $flags = Flag::all();
        $menus = Menu::orderBy('order')->get();
        $groups = ProductGroup::orderBy('position')->get();

        return view('front.products.index', compact(
            'productGroup',
            'products',
            'socialLinks',
            'flags',
            'menus',
            'groups'
        ));
    }

    /**
     * Show single product details page.
     */
    public function show($productSlug)
    {
        // Eager load product details and product group
        $product = Product::with(['details', 'productGroup'])
                    ->where('slug', $productSlug)
                    ->firstOrFail();

        // Related products from the same group (excluding current)
        $relatedProducts = Product::where('product_group_id', $product->product_group_id)
                            ->where('id', '!=', $product->id)
                            ->where('status', 1)
                            ->orderBy('position')
                            ->get();

        // Fetch menus, flags, social links for header/footer
        $socialLinks = SocialLink::all();
        $flags = Flag::all();
        $menus = Menu::orderBy('order')->get();

        // Pass all data to view
        return view('front.products.show', compact(
            'product',
            'relatedProducts',
            'socialLinks',
            'flags',
            'menus'
        ));
    }
  public function search(Request $request)
{
    $query = $request->input('query');

    $products = \App\Models\Product::where('name', 'like', "%{$query}%")->get();
     $socialLinks = SocialLink::all(); // add this line

   $flags = Flag::all(); // add this for flags

    return view('front.products.search-results', compact('products', 'query', 'socialLinks', 'flags'));
       $menus = Menu::all();                        // add this for menu

    return view('front.products.search-results', compact('products', 'query', 'socialLinks', 'flags', 'menus'));
}




    
}
