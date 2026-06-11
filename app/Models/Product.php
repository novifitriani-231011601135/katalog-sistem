<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 'price',
        'color', 'material', 'size', 'stock',
        'is_new', 'is_promo', 'is_featured',
        'main_image', 'whatsapp_number', 'tiktok_url', 'shopee_url',
    ];

    protected $casts = [
        'is_new'      => 'boolean',
        'is_promo'    => 'boolean',
        'is_featured' => 'boolean',
        'price'       => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->where('is_approved', true)->latest();
    }

    public function allReviews()
    {
        return $this->hasMany(Review::class)->latest();
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getWhatsappUrlAttribute(): string
    {
        $msg = urlencode("Halo, saya ingin bertanya lebih lanjut tentang produk *{$this->name}*. Apakah masih tersedia?");
        return "https://wa.me/{$this->whatsapp_number}?text={$msg}";
    }

    public function getAverageRatingAttribute(): float
    {
        $reviews = $this->reviews;
        if ($reviews->isEmpty()) return 0;
        return round($reviews->avg('rating'), 1);
    }
}
