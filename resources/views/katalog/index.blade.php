@extends('layouts.app')

@section('title', 'Katalog Produk - Siska Croco Jaya')

@section('content')

{{-- PAGE HEADER --}}
<div class="bg-[#1A3A2A] text-white py-12">
    <div class="max-w-screen-2xl mx-auto px-6 sm:px-10 lg:px-16">
        <nav class="flex items-center gap-2 text-sm text-gray-400 flex-wrap mb-4">
            <a href="{{ route('home') }}" class="hover:text-[#C8A84B] transition-colors">Home</a>
            <span>/</span>
            <span class="text-[#C8A84B]">Katalog</span>
        </nav>
        <h1 class="font-display text-4xl font-bold mb-2">Katalog Produk</h1>
        <p class="text-gray-300 text-base">Temukan produk kulit buaya pilihan terbaik</p>
    </div>
</div>

{{-- FILTER --}}
<section class="max-w-screen-2xl mx-auto px-6 sm:px-10 lg:px-16 py-10">
    <form method="GET" action="{{ route('katalog') }}"
          class="bg-white rounded-2xl border border-gray-100 p-8 flex flex-wrap gap-6 items-end"
          style="box-shadow: 0 4px 24px rgba(0,0,0,0.06);">
        <div class="flex-1 min-w-[220px]">
            <label class="block text-sm font-bold text-gray-400 uppercase tracking-widest mb-2">Cari Produk</label>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari produk buaya..."
                   class="w-full border border-gray-200 rounded-xl px-5 py-3 text-base focus:outline-none"
                   style="transition: border-color 0.2s;"
                   onfocus="this.style.borderColor='#C8A84B';" onblur="this.style.borderColor='#e5e7eb';">
        </div>
        <div>
            <label class="block text-sm font-bold text-gray-400 uppercase tracking-widest mb-2">Kategori</label>
            <select name="kategori" class="border border-gray-200 rounded-xl px-5 py-3 text-base focus:outline-none bg-white focus:border-[#1A3A2A]">
                <option value="semua">Semua Kategori</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->slug }}" {{ request('kategori') == $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-bold text-gray-400 uppercase tracking-widest mb-2">Warna</label>
            <select name="warna" class="border border-gray-200 rounded-xl px-5 py-3 text-base focus:outline-none bg-white focus:border-[#1A3A2A]">
                <option value="semua">Semua Warna</option>
                @foreach($colors as $color)
                <option value="{{ $color }}" {{ request('warna') == $color ? 'selected' : '' }}>{{ $color }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-bold text-gray-400 uppercase tracking-widest mb-2">Urutan</label>
            <select name="urutan" class="border border-gray-200 rounded-xl px-5 py-3 text-base focus:outline-none bg-white focus:border-[#1A3A2A]">
                <option value="terbaru">Terbaru</option>
                <option value="harga_terendah" {{ request('urutan') == 'harga_terendah' ? 'selected' : '' }}>Harga Terendah</option>
                <option value="harga_tertinggi" {{ request('urutan') == 'harga_tertinggi' ? 'selected' : '' }}>Harga Tertinggi</option>
                <option value="nama_az" {{ request('urutan') == 'nama_az' ? 'selected' : '' }}>Nama A-Z</option>
            </select>
        </div>
        <button type="submit"
                class="bg-[#1A3A2A] text-white px-8 py-3 rounded-xl text-base font-bold transition-all duration-200"
                onmouseover="this.style.backgroundColor='#0F2318';" onmouseout="this.style.backgroundColor='#1A3A2A';">
            Cari
        </button>
    </form>
</section>

{{-- PRODUK --}}
<section class="max-w-screen-2xl mx-auto px-6 sm:px-10 lg:px-16 pb-20">

    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-10">
        <div>
            <div class="inline-flex items-center gap-3 mb-3">
                <span class="block w-8 h-px bg-[#C8A84B]/60"></span>
                <span class="text-[#C8A84B] text-xs tracking-[0.3em] uppercase font-semibold">Semua Koleksi</span>
            </div>
            <h2 class="font-display text-4xl font-bold text-gray-900">Katalog Produk</h2>
        </div>
        <p class="text-base text-gray-400 pb-1">Menampilkan <strong class="text-gray-700">{{ $products->total() }}</strong> produk</p>
    </div>

    @if($products->count() > 0)
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($products as $product)
        <div class="relative group">
            <a href="{{ route('product.show', $product->slug) }}"
               class="bg-white rounded-2xl overflow-hidden border border-gray-100 block"
               style="box-shadow: 0 2px 12px rgba(0,0,0,0.05); transition: box-shadow 0.35s ease, transform 0.35s ease;"
               onmouseover="this.style.boxShadow='0 16px 48px rgba(0,0,0,0.13), 0 0 0 1px rgba(200,168,75,0.18)'; this.style.transform='translateY(-3px)';"
               onmouseout="this.style.boxShadow='0 2px 12px rgba(0,0,0,0.05)'; this.style.transform='translateY(0)';">
                <div class="aspect-square bg-gray-100 overflow-hidden relative">
                    @if($product->main_image)
                    <img src="{{ Storage::url($product->main_image) }}" alt="{{ $product->name }}"
                         class="w-full h-full object-cover"
                         style="transition: transform 0.6s cubic-bezier(0.25,0.46,0.45,0.94);"
                         onmouseover="this.style.transform='scale(1.07)';" onmouseout="this.style.transform='scale(1)';">
                    @else
                    <div class="w-full h-full flex items-center justify-center text-gray-300 text-6xl">🐊</div>
                    @endif
                    <div class="absolute top-3 left-3 flex flex-col gap-1.5">
                        @if($product->is_new)
                            <span class="bg-[#1A3A2A] text-white text-xs font-bold px-3 py-1 rounded-full">TERBARU</span>
                        @endif
                        @if($product->is_promo)
                            <span class="bg-[#C8A84B] text-[#0F2318] text-xs font-bold px-3 py-1 rounded-full">PROMO</span>
                        @endif
                    </div>
                </div>
                <div class="p-6">
                    <p class="text-sm text-[#C8A84B] uppercase tracking-widest mb-2 font-semibold">{{ $product->category->name ?? '' }}</p>
                    <h3 class="font-semibold text-gray-800 text-base mb-3 line-clamp-2 leading-snug">{{ $product->name }}</h3>
                    <div class="flex items-center justify-between">
                        <p class="text-gray-900 font-bold text-lg">{{ $product->formatted_price }}</p>
                        <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </a>

            {{-- Tombol favorit --}}
            <button
                data-fav-id="{{ $product->id }}"
                onclick="toggleFav('{{ $product->id }}','{{ addslashes($product->name) }}','{{ $product->formatted_price }}','{{ Storage::url($product->main_image) }}','{{ route('product.show', $product->slug) }}')"
                class="absolute top-3 right-3 w-9 h-9 rounded-full flex items-center justify-center bg-white/80 backdrop-blur-sm hover:bg-white shadow-sm transition-all duration-200 hover:scale-110 z-10"
                aria-label="Simpan ke favorit">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                     style="transition: fill .2s, stroke .2s;">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </button>
        </div>
        @endforeach
    </div>
    <div class="mt-10">{{ $products->links() }}</div>
    @else
    <div class="text-center py-28 text-gray-400">
        <div class="text-7xl mb-6">🔍</div>
        <p class="text-2xl font-semibold text-gray-600 mb-3">Produk tidak ditemukan</p>
        <p class="text-lg mt-2">Coba ubah filter atau kata kunci pencarian</p>
        <a href="{{ route('katalog') }}" class="inline-block mt-8 bg-[#1A3A2A] text-white text-base font-bold px-8 py-4 rounded-full hover:bg-[#0F2318] transition">Lihat Semua Produk</a>
    </div>
    @endif
</section>

@endsection