<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('sort_order')->get();
        return view('admin.banner.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banner.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'      => 'required|string|max:100',
            'image'      => 'required|image|max:5120',
            'link'       => 'nullable|url',
            'sort_order' => 'nullable|integer',
        ]);
        $data['image']     = $request->file('image')->store('banners', 'public');
        $data['is_active'] = $request->boolean('is_active');
        Banner::create($data);
        return redirect()->route('admin.banner.index')->with('success', 'Banner berhasil ditambahkan!');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banner.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $data = $request->validate([
            'title'      => 'required|string|max:100',
            'image'      => 'nullable|image|max:5120',
            'link'       => 'nullable|url',
            'sort_order' => 'nullable|integer',
        ]);
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($banner->image);
            $data['image'] = $request->file('image')->store('banners', 'public');
        } else {
            unset($data['image']);
        }
        $data['is_active'] = $request->boolean('is_active');
        $banner->update($data);
        return redirect()->route('admin.banner.index')->with('success', 'Banner berhasil diupdate!');
    }

    public function destroy(Banner $banner)
    {
        Storage::disk('public')->delete($banner->image);
        $banner->delete();
        return redirect()->route('admin.banner.index')->with('success', 'Banner dihapus!');
    }
}
