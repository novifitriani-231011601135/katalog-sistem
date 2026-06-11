@extends('layouts.app')

@section('title', 'Siska Croco Jaya - Produk Kulit Buaya Premium')

@section('content')

{{-- BANNER SLIDER --}}
@php $activeBanners = \App\Models\Banner::where('is_active', true)->orderBy('sort_order')->get(); @endphp
@if($activeBanners->isNotEmpty())
<section class="w-full overflow-hidden relative" x-data="{ current: 0, total: {{ $activeBanners->count() }} }" x-init="setInterval(() => current = (current+1) % total, 4000)">
    <div class="flex transition-transform duration-700" :style="'transform: translateX(-' + (current * 100) + '%)'">
        @foreach($activeBanners as $banner)
        <div class="min-w-full">
            @if($banner->link)
            <a href="{{ $banner->link }}" target="_blank" rel="noopener">
                <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title }}" class="w-full object-cover" style="max-height:none; width:100%; height:auto; object-fit:contain;">
            </a>
            @else
            <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title }}" class="w-full object-cover" style="max-height:none; width:100%; height:auto; object-fit:contain;">
            @endif
        </div>
        @endforeach
    </div>
    @if($activeBanners->count() > 1)
    <div class="absolute bottom-3 left-0 right-0 flex justify-center gap-2">
        @foreach($activeBanners as $i => $b)
        <button @click="current = {{ $i }}" :class="current === {{ $i }} ? 'bg-white w-6' : 'bg-white/50 w-2'" class="h-2 rounded-full transition-all duration-300"></button>
        @endforeach
    </div>
    @endif
</section>
@endif

{{-- HERO --}}
<section class="bg-[#0F2318] text-white relative overflow-hidden">
    <div class="absolute inset-0 pointer-events-none"
         style="background-image: radial-gradient(circle, rgba(200,168,75,0.07) 1px, transparent 1px); background-size: 32px 32px;"></div>
    <div class="absolute top-0 left-0 right-0 h-px"
         style="background: linear-gradient(to right, transparent, rgba(200,168,75,0.45), transparent);"></div>

    <div class="max-w-screen-2xl mx-auto px-6 sm:px-10 lg:px-16 py-24 md:py-36">
        <div class="grid md:grid-cols-2 gap-16 items-center">
            <div class="relative z-10">
                <div class="inline-flex items-center gap-4 mb-10">
                    <span class="block w-14 h-px bg-[#C8A84B]/60"></span>
                    <span class="text-[#C8A84B] text-sm tracking-[0.35em] uppercase font-semibold">Brand Kulit Buaya Premium</span>
                    <span class="block w-14 h-px bg-[#C8A84B]/60"></span>
                </div>
                <h1 class="font-display font-bold leading-[1.0] mb-8 tracking-tight"
                    style="font-size: clamp(3.5rem, 6vw, 5.5rem);">
                    KUALITAS<br>
                    <span class="text-[#C8A84B]">PREMIUM,</span><br>
                    DETAIL<br>SEMPURNA
                </h1>
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-px bg-[#C8A84B]/40"></div>
                    <div class="w-2 h-2 rounded-full bg-[#C8A84B]/50"></div>
                    <div class="w-24 h-px bg-[#C8A84B]/20"></div>
                </div>
                <p class="text-gray-300 text-xl mb-12 leading-relaxed max-w-md">
                    Produk kulit buaya asli pilihan terbaik untuk gaya hidup berkelas dan tahan lama. Setiap detail dirancang dengan penuh ketelitian.
                </p>
                <div class="flex flex-wrap gap-5">
                    <a href="{{ route('katalog') }}"
                       class="group inline-flex items-center gap-3 bg-[#C8A84B] text-[#0F2318] font-bold px-10 py-5 rounded-full text-lg transition-all duration-300"
                       onmouseover="this.style.backgroundColor='#D4B460'; this.style.transform='scale(1.02)';"
                       onmouseout="this.style.backgroundColor='#C8A84B'; this.style.transform='scale(1)';">
                        Lihat Koleksi
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    <a href="https://wa.me/6285891056675?text={{ urlencode('Halo, saya ingin bertanya tentang produk Siska Croco Jaya.') }}"
                       target="_blank" rel="noopener"
                       class="inline-flex items-center gap-3 border-2 text-white px-10 py-5 rounded-full text-lg font-semibold transition-all duration-300"
                       style="border-color: rgba(255,255,255,0.3);"
                       onmouseover="this.style.borderColor='rgba(255,255,255,0.7)'; this.style.backgroundColor='rgba(255,255,255,0.06)';"
                       onmouseout="this.style.borderColor='rgba(255,255,255,0.3)'; this.style.backgroundColor='transparent';">
                        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z"/>
                            <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.557 4.126 1.533 5.864L.057 23.571a.5.5 0 00.61.61l5.695-1.476A11.953 11.953 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.006-1.372l-.358-.214-3.716.964.988-3.617-.234-.372A9.818 9.818 0 1112 21.818z"/>
                        </svg>
                        Hubungi Kami
                    </a>
                </div>
            </div>
            <div class="hidden md:block relative">
                <div class="absolute -inset-6 rounded-[48px] pointer-events-none"
                     style="background: radial-gradient(ellipse at center, rgba(200,168,75,0.18), transparent 70%);"></div>
                <div class="relative rounded-[32px] overflow-hidden"
                     style="box-shadow: 0 40px 90px rgba(0,0,0,0.65), 0 0 0 1px rgba(200,168,75,0.18);">
                    <div class="absolute inset-0 z-10 pointer-events-none"
                         style="background: linear-gradient(to right, rgba(15,35,24,0.35) 0%, transparent 35%, transparent 65%, rgba(15,35,24,0.25) 100%);"></div>
                    <div class="absolute inset-0 z-10 pointer-events-none"
                         style="background: linear-gradient(to bottom, rgba(15,35,24,0.15) 0%, transparent 40%, rgba(15,35,24,0.55) 100%);"></div>
                    <div class="absolute top-5 right-5 z-20 pointer-events-none" style="width:56px;height:56px;">
                        <div style="position:absolute;top:0;right:0;width:100%;height:1px;background:#C8A84B;opacity:0.7;"></div>
                        <div style="position:absolute;top:0;right:0;width:1px;height:100%;background:#C8A84B;opacity:0.7;"></div>
                    </div>
                    <div class="absolute bottom-5 left-5 z-20 pointer-events-none" style="width:56px;height:56px;">
                        <div style="position:absolute;bottom:0;left:0;width:100%;height:1px;background:#C8A84B;opacity:0.7;"></div>
                        <div style="position:absolute;bottom:0;left:0;width:1px;height:100%;background:#C8A84B;opacity:0.7;"></div>
                    </div>
                    <img src="{{ asset('images/kulit.jpg') }}"
                         alt="Kulit Buaya Premium Siska Croco Jaya"
                         class="w-full object-cover"
                         style="aspect-ratio: 4/3; filter: brightness(0.88) contrast(1.12) saturate(1.08); transition: transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);"
                         onmouseover="this.style.transform='scale(1.04)';"
                         onmouseout="this.style.transform='scale(1)';">
                    <div class="absolute bottom-0 left-0 right-0 z-20 px-8 py-6 pointer-events-none">
                        <p class="text-xs tracking-[0.3em] uppercase text-[#C8A84B]/80 font-semibold">Siska Croco Jaya</p>
                        <p class="text-white/60 text-sm mt-1">Kulit Buaya Asli · Premium Quality</p>
                    </div>
                </div>
                <div class="absolute -bottom-5 -right-5 rounded-2xl px-6 py-4 z-30"
                     style="background: #1A3A2A; border: 1px solid rgba(200,168,75,0.3); box-shadow: 0 16px 40px rgba(0,0,0,0.4);">
                    <p class="text-[#C8A84B] font-bold text-3xl font-display leading-none">100%</p>
                    <p class="text-gray-400 text-xs tracking-widest uppercase mt-1">Kulit Asli</p>
                </div>
            </div>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 h-px"
         style="background: linear-gradient(to right, transparent, rgba(200,168,75,0.3), transparent);"></div>
</section>

{{-- PRODUK UNGGULAN --}}
@php
    $produkUnggulan = \App\Models\Product::with('category')
        ->where('is_featured', true)
        ->latest()
        ->limit(8)
        ->get();
    if ($produkUnggulan->isEmpty()) {
        $produkUnggulan = \App\Models\Product::with('category')->latest()->limit(8)->get();
    }
@endphp

<section class="max-w-screen-2xl mx-auto px-6 sm:px-10 lg:px-16 py-20">
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-10">
        <div>
            <div class="inline-flex items-center gap-3 mb-3">
                <span class="block w-8 h-px bg-[#C8A84B]/60"></span>
                <span class="text-[#C8A84B] text-xs tracking-[0.3em] uppercase font-semibold">Koleksi Pilihan</span>
            </div>
            <h2 class="font-display text-4xl font-bold text-gray-900">Produk Unggulan</h2>
        </div>
        <a href="{{ route('katalog') }}"
           class="inline-flex items-center gap-2 border-2 border-[#1A3A2A] text-[#1A3A2A] font-bold px-6 py-3 rounded-full text-base transition-all duration-200"
           onmouseover="this.style.background='#1A3A2A'; this.style.color='#fff';"
           onmouseout="this.style.background='transparent'; this.style.color='#1A3A2A';">
            Lihat Semua Produk
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </a>
    </div>

    @if($produkUnggulan->count() > 0)
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($produkUnggulan as $product)
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
    @else
    <div class="text-center py-20 text-gray-400">
        <div class="text-7xl mb-6">🐊</div>
        <p class="text-xl font-semibold text-gray-500 mb-3">Belum ada produk unggulan</p>
        <p class="text-base">Tandai produk sebagai unggulan di panel admin</p>
    </div>
    @endif
</section>

{{-- ULASAN PELANGGAN --}}
@php
    $ulasanHomepage = \App\Models\Review::with('product')
        ->where('is_approved', true)->latest()->limit(3)->get();
    $avgRating   = \App\Models\Review::where('is_approved', true)->avg('rating') ?? 0;
    $totalUlasan = \App\Models\Review::where('is_approved', true)->count();
@endphp

@if($ulasanHomepage->isNotEmpty())
<section class="bg-[#F7F4EE] py-20">
    <div class="max-w-screen-xl mx-auto px-6 sm:px-10 lg:px-16">
        <div class="text-center mb-10">
            <p class="text-xs font-bold tracking-[3px] text-[#C8A84B] uppercase mb-2">Testimoni</p>
            <h2 class="text-3xl md:text-4xl font-bold text-[#1A3A2A]">Apa Kata Mereka?</h2>
            <p class="text-gray-500 mt-2 text-sm">Ulasan nyata dari pelanggan setia kami</p>
        </div>
        <div class="flex items-center justify-center gap-6 bg-white rounded-2xl px-8 py-5 max-w-xs mx-auto mb-8 border border-[#C8A84B]/20">
            <div class="text-5xl font-bold text-[#1A3A2A] leading-none">{{ number_format($avgRating, 1) }}</div>
            <div>
                <div class="flex gap-1 mb-1">
                    @for($i=1;$i<=5;$i++)
                    <svg width="16" height="16" viewBox="0 0 24 24"
                         fill="{{ $i <= round($avgRating) ? '#F59E0B' : '#E5E7EB' }}"
                         stroke="{{ $i <= round($avgRating) ? '#F59E0B' : '#D1D5DB' }}" stroke-width="1">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    @endfor
                </div>
                <div class="text-xs text-gray-400">Dari {{ $totalUlasan }} ulasan</div>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($ulasanHomepage as $ul)
            <div class="bg-white rounded-2xl p-6 border border-[#C8A84B]/15">
                <div class="flex gap-1 mb-3">
                    @for($i=1;$i<=5;$i++)
                    <svg width="16" height="16" viewBox="0 0 24 24"
                         fill="{{ $i <= $ul->rating ? '#F59E0B' : '#E5E7EB' }}"
                         stroke="{{ $i <= $ul->rating ? '#F59E0B' : '#D1D5DB' }}" stroke-width="1">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    @endfor
                </div>
                <p class="text-gray-600 text-sm leading-relaxed italic mb-5">"{{ $ul->comment }}"</p>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-[#1A3A2A] flex items-center justify-center text-[#C8A84B] text-xs font-bold flex-shrink-0">
                        {{ strtoupper(substr($ul->name, 0, 2)) }}
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-[#1A3A2A]">{{ $ul->name }}</div>
                        <div class="text-xs text-gray-400">{{ $ul->product->name ?? 'Produk Siska Croco' }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection