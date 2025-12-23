<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\SocialLink;
use App\Models\Flag;
use App\Models\Banner; // for banners
use App\Models\ProductGroup; // <-- new

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
        // Fetch all active product groups, ordered by position
        $groups = ProductGroup::where('status', 1)->orderBy('position')->get();

        // Pass all data to the view
        return view('front.home', compact('menus', 'socialLinks', 'flags', 'banners', 'groups'));
    }
}
