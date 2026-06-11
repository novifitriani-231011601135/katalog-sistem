<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('product')->latest()->get();
        return view('admin.ulasan.index', compact('reviews'));
    }

    public function approve(Review $ulasan)
    {
        $ulasan->update(['is_approved' => true]);
        return back()->with('success', 'Ulasan disetujui!');
    }

    public function reject(Review $ulasan)
    {
        $ulasan->update(['is_approved' => false]);
        return back()->with('success', 'Ulasan ditolak!');
    }

    public function destroy(Review $ulasan)
    {
        $ulasan->delete();
        return back()->with('success', 'Ulasan dihapus!');
    }
}
