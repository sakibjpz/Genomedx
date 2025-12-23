<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Flag;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FlagController extends Controller
{
    public function index()
    {
        $flags = Flag::all();
        return view('admin.flags.index', compact('flags'));
    }

    public function create()
    {
        return view('admin.flags.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:50',
            'image' => 'required|image|mimes:jpg,jpeg,png,svg|max:2048',
        ]);

        $path = $request->file('image')->store('flags', 'public');

        Flag::create([
            'name'    => $request->name,
            'country' => $request->name,
            'code'    => strtoupper(Str::substr($request->name, 0, 2)),
            'image'   => basename($path),
            'icon'    => 'flag-icon', // default value to satisfy DB
        ]);

        return redirect()
            ->route('admin.flags.index')
            ->with('success', 'Flag created successfully.');
    }

    public function edit(Flag $flag)
    {
        return view('admin.flags.edit', compact('flag'));
    }

    public function update(Request $request, Flag $flag)
    {
        $request->validate([
            'name'  => 'required|string|max:50',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($flag->image && Storage::disk('public')->exists('flags/' . $flag->image)) {
                Storage::disk('public')->delete('flags/' . $flag->image);
            }

            $path = $request->file('image')->store('flags', 'public');
            $flag->image = basename($path);
        }

        $flag->name    = $request->name;
        $flag->country = $request->name;
        $flag->code    = strtoupper(Str::substr($request->name, 0, 2));
        $flag->icon    = $flag->icon ?? 'flag-icon'; // ensure icon always has value
        $flag->save();

        return redirect()
            ->route('admin.flags.index')
            ->with('success', 'Flag updated successfully.');
    }

    public function destroy(Flag $flag)
    {
        if ($flag->image && Storage::disk('public')->exists('flags/' . $flag->image)) {
            Storage::disk('public')->delete('flags/' . $flag->image);
        }

        $flag->delete();

        return redirect()
            ->route('admin.flags.index')
            ->with('success', 'Flag deleted successfully.');
    }
}
