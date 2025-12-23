<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('order')->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

  public function store(Request $request)
{
    $request->validate([
        'title' => 'required',
        'image' => 'required|image',
    ]);

    $imageName = time() . '.' . $request->image->extension();
    $request->image->move(public_path('images'), $imageName);

    // Better order calculation
    $maxOrder = Banner::max('order') ?? 0;
    
    Banner::create([
        'title'        => $request->title,
        'subtitle'     => $request->subtitle,
        'image'        => $imageName,
        'button_text'  => $request->button_text,
        'button_url'   => $request->button_url,
        'order'        => $maxOrder + 1,
    ]);

    return redirect()->route('admin.banners.index')
                     ->with('success', 'Banner added successfully');
}
    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $request->validate([
            'title' => 'required',
        ]);

        $imageName = $banner->image;

        if ($request->hasFile('image')) {
            // delete old image
            $oldPath = public_path('images/' . $banner->image);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }

            // upload new image
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
        }

        $banner->update([
            'title'        => $request->title,
            'subtitle'     => $request->subtitle,
            'image'        => $imageName,
            'button_text'  => $request->button_text,
            'button_url'   => $request->button_url,
        ]);

        return redirect()->route('admin.banners.index')
                         ->with('success', 'Banner updated successfully');
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);

        // delete image file
        $imagePath = public_path('images/' . $banner->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // delete record
        $banner->delete();

        return redirect()->route('admin.banners.index')
                         ->with('success', 'Banner deleted successfully');
    }

    public function reorder(Request $request)
    {
        foreach ($request->order as $index => $id) {
            Banner::where('id', $id)->update(['order' => $index]);
        }

        return response()->json(['status' => 'success']);
    }
}
