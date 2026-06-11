<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $parents = Category::whereNull('parent_id')
            ->with(['children' => fn($q) => $q->withCount('products')])
            ->withCount('products')
            ->orderBy('name')
            ->get();
        return view('admin.kategori.index', compact('parents'));
    }

    public function create()
    {
        $parentCategories = Category::whereNull('parent_id')->orderBy('name')->get();
        return view('admin.kategori.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:100|unique:categories,name',
            'parent_id' => 'nullable|exists:categories,id',
        ]);
        $data['slug'] = str($data['name'])->slug();
        Category::create($data);
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit(Category $kategori)
    {
        $parentCategories = Category::whereNull('parent_id')
            ->where('id', '!=', $kategori->id)
            ->orderBy('name')
            ->get();
        return view('admin.kategori.edit', compact('kategori', 'parentCategories'));
    }

    public function update(Request $request, Category $kategori)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:100|unique:categories,name,' . $kategori->id,
            'parent_id' => 'nullable|exists:categories,id',
        ]);
        $data['slug'] = str($data['name'])->slug();
        $kategori->update($data);
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diupdate!');
    }

    public function destroy(Category $kategori)
    {
        $kategori->delete();
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
