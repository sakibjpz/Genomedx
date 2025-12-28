<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\SocialLink;
use App\Models\Flag;
use App\Models\Banner;
use App\Models\ProductGroup;
use App\Models\Company;
use App\Models\Setting; // Add this line
use App\Models\News; 

class HomeController extends Controller
{
    public function frontHome()
    {
        // Fetch menus from database, ordered by 'order' column
        $menus = Menu::orderBy('order')->get();

        // Fetch social links from database
        $socialLinks = SocialLink::all();

        // Fetch flags from database
        $flags = Flag::all();

        // Fetch all banners, ordered by 'id' or a custom 'order' column
        $banners = Banner::orderBy('order')->get();
        
        // Get setting for which company to show
        $selectedCompanyId = Setting::getValue('frontend_company_id');
        
        // Fetch product groups based on setting
        if ($selectedCompanyId) {
            // Show only selected company's product groups
            $groups = ProductGroup::where('company_id', $selectedCompanyId)
                ->where('status', 1)
                ->withCount('products')
                ->orderBy('position')
                ->get();
        } else {
            // Show all active product groups
            $groups = ProductGroup::where('status', 1)
                ->withCount('products')
                ->orderBy('position')
                ->get();
        }
        
        // Fetch active companies with product group count (for mega menu)
        $companies = Company::where('is_active', true)
            ->withCount('activeProductGroups')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

       // Fetch latest news (3 items)
    $latestNews = News::published()->latestNews(3)->get();

    // Pass all data to the view (add 'latestNews' to compact)
    return view('front.home', compact('menus', 'socialLinks', 'flags', 'banners', 'groups', 'companies', 'latestNews'));
    }
}