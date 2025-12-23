<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::whereNull('parent_id')
            ->with('children') // load submenus
            ->orderBy('order')
            ->get();

        return view('admin.menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menus = Menu::all();
        return view('admin.menus.create', compact('menus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'order' => 'nullable|integer',
            'status' => 'required|boolean',
        ]);

        Menu::create($request->all());

        return redirect()->route('admin.menus.index')->with('success', 'Menu created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $menu = Menu::with('children')->findOrFail($id); // load children
        return view('admin.menus.edit', compact('menu'));
    }

    /**
     * Update the specified resource in storage along with submenus.
     */
    public function update(Request $request, Menu $menu)
    {
        // Validate parent menu
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'order' => 'nullable|integer',
            'status' => 'required|boolean',
            // Children validation
            'children.*.name' => 'required|string|max:255',
            'children.*.order' => 'nullable|integer',
            'children.*.status' => 'required|boolean',
        ]);

        // Update parent menu
        $menu->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'order' => $request->order ?? 0,
            'status' => $request->status,
        ]);

        // Update children if any
        if ($request->has('children')) {
            foreach ($request->children as $childId => $childData) {
                $childMenu = Menu::find($childId);
                if ($childMenu) {
                    $childMenu->update([
                        'name' => $childData['name'],
                        'order' => $childData['order'] ?? 0,
                        'status' => $childData['status'],
                    ]);
                }
            }
        }

        return redirect()->route('admin.menus.index')->with('success', 'Menu and submenus updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
public function destroy(Menu $menu)
{
    $menu->delete();
    return redirect()->route('admin.menus.index')->with('success', 'Menu deleted successfully.');
}
    

    /**
     * Reorder menus.
     */
    public function reorder(Request $request)
    {
        foreach ($request->order as $index => $menuId) {
            Menu::where('id', $menuId)->update(['order' => $index]);
        }

        return response()->json(['status' => 'success']);
    }
}
