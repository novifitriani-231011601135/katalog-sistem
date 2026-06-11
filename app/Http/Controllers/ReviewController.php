<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $product->allReviews()->create([
            'name'        => $request->name,
            'rating'      => $request->rating,
            'comment'     => $request->comment,
            'is_approved' => false,
        ]);

        return back()->with('success', 'Terima kasih! Ulasan kamu sedang menunggu persetujuan admin.');
    }
}
