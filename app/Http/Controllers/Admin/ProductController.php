<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        return view('admin.produk.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.produk.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required',
            'category_id'     => 'required',
            'price'           => 'required',
            'stock'           => 'required|numeric',
            'color'           => 'nullable|string|max:100',
            'material'        => 'nullable|string|max:150',
            'size'            => 'nullable|string|max:200',
            'main_image'      => 'nullable|image|max:5120',
            'whatsapp_number' => 'nullable|string|max:20',
            'shopee_url'      => 'nullable|url',
            'tiktok_url'      => 'nullable|url',
        ]);

        $data = $request->except(['_token', 'extra_images', 'main_image']);
        $data['price']       = str_replace('.', '', $request->price);
        $data['description'] = $request->input('description', '');
        $data['slug']        = str($request->name)->slug();
        $data['is_new']      = $request->boolean('is_new');
        $data['is_promo']    = $request->boolean('is_promo');
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('main_image')) {
            $data['main_image'] = $request->file('main_image')->store('products', 'public');
        }

        $product = Product::create($data);

        if ($request->hasFile('extra_images')) {
            foreach ($request->file('extra_images') as $i => $file) {
                $product->images()->create([
                    'image_path' => $file->store('products', 'public'),
                    'sort_order' => $i,
                ]);
            }
        }

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $produk)
    {
        $categories = Category::all();
        return view('admin.produk.edit', compact('produk', 'categories'));
    }

    public function update(Request $request, Product $produk)
    {
        $request->validate([
            'name'            => 'required',
            'category_id'     => 'required',
            'price'           => 'required',
            'stock'           => 'required|numeric',
            'color'           => 'nullable|string|max:100',
            'material'        => 'nullable|string|max:150',
            'size'            => 'nullable|string|max:200',
            'main_image'      => 'nullable|image|max:5120',
            'whatsapp_number' => 'nullable|string|max:20',
            'shopee_url'      => 'nullable|url',
            'tiktok_url'      => 'nullable|url',
        ]);

        $data = $request->except(['_token', '_method', 'extra_images', 'main_image']);
        $data['price']       = str_replace('.', '', $request->price);
        $data['description'] = $request->input('description', '');
        $data['slug']        = str($request->name)->slug();
        $data['is_new']      = $request->boolean('is_new');
        $data['is_promo']    = $request->boolean('is_promo');
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('main_image')) {
            $data['main_image'] = $request->file('main_image')->store('products', 'public');
        } else {
            unset($data['main_image']);
        }

        $produk->update($data);

        if ($request->hasFile('extra_images')) {
            $lastOrder = $produk->images()->max('sort_order') ?? -1;
            foreach ($request->file('extra_images') as $i => $file) {
                $produk->images()->create([
                    'image_path' => $file->store('products', 'public'),
                    'sort_order' => $lastOrder + $i + 1,
                ]);
            }
        }

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy(Product $produk)
    {
        $produk->delete();
        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus!');
    }

    public function destroyImage(ProductImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $product = $image->product;
        $image->delete();
        return redirect()->route('admin.produk.edit', $product)->with('success', 'Foto berhasil dihapus!');
    }
}