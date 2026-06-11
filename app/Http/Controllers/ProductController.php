<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'images']);

        if ($request->filled('q')) {
            $query->where('name', 'like', "%{$request->q}%");
        }

        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->kategori));
        }

        if ($request->filled('warna') && $request->warna !== 'semua') {
            $query->where('color', $request->warna);
        }

        if ($request->filled('harga_max') && is_numeric($request->harga_max)) {
            $maxDb = (int) (Product::max('price') ?: 10000000);
            if ((int) $request->harga_max < $maxDb) {
                $query->where('price', '<=', $request->harga_max);
            }
        }

        // Filter terlaris
        if ($request->get('filter') === 'terlaris') {
            $query->where('is_featured', true);
        }
        // Filter produk baru
        if ($request->get('filter') === 'baru') {
            $query->where('is_new', true);
        }

        match ($request->get('urutan', 'terbaru')) {
            'harga_terendah'  => $query->orderBy('price', 'asc'),
            'harga_tertinggi' => $query->orderBy('price', 'desc'),
            'nama_az'         => $query->orderBy('name', 'asc'),
            default           => $query->latest(),
        };

        $isKatalog  = $request->routeIs('katalog');
        $products   = $query->paginate($isKatalog ? 12 : 8)->withQueryString();
        $categories = Category::all();
        $colors     = Product::distinct()->orderBy('color')->pluck('color');
        $maxPrice   = (int) (Product::max('price') ?: 10000000);

        $view = $isKatalog ? 'katalog.index' : 'home.index';
        return view($view, compact('products', 'categories', 'colors', 'maxPrice'));
    }

    public function show(Product $product)
    {
        $product->load(['category', 'images', 'reviews']);

        $related = Product::with('images')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'related'));
    }
}
