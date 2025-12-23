<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\SocialLink;
use App\Models\Flag;
use App\Models\Banner;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'menusCount' => Menu::count(),
            'socialLinksCount' => SocialLink::count(),
            'flagsCount' => Flag::count(),
            'bannersCount' => Banner::count(),
        ]);
    }
}
