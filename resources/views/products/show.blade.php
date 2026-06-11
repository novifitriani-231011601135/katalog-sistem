@extends('layouts.app')

@section('title', "{$product->name} - Siska Croco Jaya")

@section('content')

{{-- Dark Header dengan Breadcrumb --}}
<div class="bg-[#1A3A2A] text-white py-16">
    <div class="max-w-screen-2xl mx-auto px-6 sm:px-10 lg:px-16">
        <nav class="flex items-center gap-2 text-base text-gray-400 flex-wrap">
            <a href="{{ route('home') }}" class="hover:text-[#C8A84B] transition-colors">Home</a>
            <span>/</span>
            <a href="{{ route('katalog') }}" class="hover:text-[#C8A84B] transition-colors">Katalog</a>
            <span>/</span>
            <span class="text-[#C8A84B] truncate max-w-[400px]">{{ $product->name }}</span>
        </nav>
    </div>
</div>

<div class="max-w-screen-2xl mx-auto px-6 sm:px-10 lg:px-16 py-14">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20">

        {{-- LEFT: Product Gallery --}}
        @php
            $mainImgUrl = Storage::url($product->main_image);
            $allImages  = collect([['url' => $mainImgUrl]])->merge(
                $product->images->map(fn($img) => ['url' => Storage::url($img->image_path)])
            );
        @endphp
        <div x-data="{ active: '{{ $mainImgUrl }}' }" class="sticky top-4">
            <div class="aspect-square rounded-3xl overflow-hidden bg-gray-50 mb-4 border border-gray-100 shadow-sm">
                <img :src="active" alt="{{ $product->name }}" class="w-full h-full object-cover transition-opacity duration-300">
            </div>
            @if($allImages->count() > 1)
                <div class="grid grid-cols-5 gap-2">
                    @foreach($allImages as $img)
                        <button @click="active = '{{ $img['url'] }}'"
                                class="aspect-square rounded-xl overflow-hidden border-2 transition-all duration-200"
                                :class="active === '{{ $img['url'] }}' ? 'border-[#1A3A2A] ring-2 ring-[#1A3A2A]/40 scale-95' : 'border-gray-200 hover:border-[#C8A84B]'">
                            <img src="{{ $img['url'] }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- RIGHT: Product Info --}}
        <div>
            <div class="flex items-center gap-3 mb-4 flex-wrap">
                <span class="text-sm uppercase tracking-widest text-gray-400 font-semibold">{{ $product->category->name }}</span>
                @if($product->is_new)
                    <span class="bg-[#1A3A2A] text-white text-xs font-bold px-3 py-1 rounded-full">TERBARU</span>
                @endif
                @if($product->is_promo)
                    <span class="bg-[#C8A84B] text-[#0F2318] text-xs font-bold px-3 py-1 rounded-full">PROMO</span>
                @endif
                @if($product->is_featured)
                    <span class="bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full">🔥 TERLARIS</span>
                @endif
            </div>

            <h1 class="font-display text-4xl md:text-5xl font-bold text-gray-900 leading-tight mb-6">
                {{ $product->name }}
            </h1>

            <div class="text-4xl font-bold text-[#1A3A2A] mb-8">
                {{ $product->formatted_price }}
            </div>

            {{-- DESKRIPSI --}}
            @php
                $rawDesc = $product->description ?? '';
                $displaySize = $product->size;
                if (!$displaySize && $rawDesc) {
                    if (preg_match('/Ukuran[:\s]+((?:(?:Panjang|Tinggi|Lebar|Diameter|Tebal)[:\s]+[\d,.]+\s*cm\s*){1,5})/ui', $rawDesc, $m)) {
                        $displaySize = trim(preg_replace('/\s+/', ' ', $m[1]));
                    } elseif (preg_match('/(?:Panjang|Tinggi|Lebar)[:\s]+[\d,.]+\s*cm(?:\s+(?:Panjang|Tinggi|Lebar)[:\s]+[\d,.]+\s*cm)*/ui', $rawDesc, $m)) {
                        $displaySize = trim(preg_replace('/\s+/', ' ', $m[0]));
                    }
                }
                $displayMaterial = $product->material;
                if (!$displayMaterial && $rawDesc) {
                    if (preg_match('/(?:Material|Bahan)[:\s]+([\w\s&,\-]+?)(?=\s*(?:Ukuran|Warna|Detail|Stok|Inner|Dilengkapi|\n|$))/ui', $rawDesc, $m)) {
                        $displayMaterial = trim($m[1]);
                    }
                }
                $intro = ''; $whyItems = []; $detailItems = []; $qualityNote = '';
                if (preg_match("/\xe2\x9c\xa8\s*Why\s+You'?ll\s+Love[\s\w]*\xe2\x9c\xa8(.*?)(?=Detail\s+Produk|$)/uis", $rawDesc, $whyMatch)) {
                    $introRaw = mb_substr($rawDesc, 0, mb_strpos($rawDesc, $whyMatch[0]));
                    $intro    = rtrim(trim(preg_replace('/\s+/', ' ', $introRaw)), " \xe2\x9c\xa8\xf0\x9f\x92\x9c\xf0\x9f\x91\x9c\xf0\x9f\xa4\x8e\xf0\x9f\x90\x8a\xf0\x9f\x92\x99\xf0\x9f\x96\xa4\xf0\x9f\xa4\x8d");
                    $whyRaw   = trim($whyMatch[1]);
                    foreach (preg_split('/\xe2\x9c\xa8/', $whyRaw) as $part) { $part = trim($part); if ($part) $whyItems[] = $part; }
                } elseif (mb_strpos($rawDesc, '•') !== false) {
                    $bulletPos = mb_strpos($rawDesc, '•');
                    $intro     = rtrim(trim(mb_substr($rawDesc, 0, $bulletPos)), " \xe2\x9c\xa8\xf0\x9f\x92\x9c\xf0\x9f\x91\x9c");
                    preg_match_all('/[•]\s*(.+)/u', $rawDesc, $bm);
                    $whyItems  = $bm[1] ?? [];
                } else {
                    $intro = rtrim(trim(preg_replace('/\s+/', ' ', $rawDesc)), " \xe2\x9c\xa8\xf0\x9f\x92\x9c\xf0\x9f\x91\x9c");
                }
                if (preg_match('/Detail\s+Produk\s*(.*?)(?=Produk dikirim|Ukuran\s+Panjang|$)/uis', $rawDesc, $detailMatch)) {
                    $lines = preg_split('/\n/', trim($detailMatch[1]));
                    if (count($lines) <= 1) { $lines = preg_split('/(?<=[a-z\)\.0-9])(?=[A-Z1-9]|\d+\s+ruang)/u', trim($detailMatch[1])); }
                    foreach ($lines as $line) { $line = trim($line); if (mb_strlen($line) > 3) $detailItems[] = $line; }
                }
                if (preg_match('/(Produk dikirim[^\.]+\.)/ui', $rawDesc, $qm)) { $qualityNote = trim($qm[1]); }
            @endphp

            <div class="mb-10 pb-8 border-b border-gray-100 space-y-5">
                @if($intro)
                    <p class="text-gray-600 text-lg leading-relaxed">{{ $intro }}</p>
                @endif
                @if(count($whyItems) > 0)
                    <div class="rounded-2xl bg-[#F7F4EE] border border-[#C8A84B]/25 p-6">
                        <p class="text-xs font-bold text-[#C8A84B] uppercase tracking-[0.2em] mb-4">✦ Why You'll Love It</p>
                        <ul class="space-y-2.5">
                            @foreach($whyItems as $item)
                                <li class="flex items-start gap-3">
                                    <span class="text-[#C8A84B] flex-shrink-0 mt-0.5">✦</span>
                                    <span class="text-gray-700 text-base leading-snug">{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(count($detailItems) > 0)
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Detail Produk</p>
                        <ul class="space-y-2">
                            @foreach($detailItems as $item)
                                <li class="flex items-start gap-2.5 text-gray-600 text-base">
                                    <svg class="w-3.5 h-3.5 text-[#1A3A2A] flex-shrink-0 mt-1.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    {{ $item }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if($qualityNote)
                    <p class="text-sm text-gray-400 italic border-l-2 border-[#C8A84B]/50 pl-4">{{ $qualityNote }}</p>
                @endif
            </div>

            {{-- Key Specs --}}
            <div class="grid grid-cols-3 gap-4 mb-10">
                @if($displayMaterial)
                <div class="rounded-2xl border border-[#C8A84B]/30 bg-gradient-to-b from-[#FAF7EE] to-white p-5 text-center">
                    <p class="text-sm text-gray-400 uppercase tracking-wide mb-2 font-semibold">Bahan</p>
                    <p class="text-base font-bold text-[#1A3A2A] leading-tight">{{ $displayMaterial }}</p>
                </div>
                @endif
                @if($displaySize)
                <div class="rounded-2xl border border-[#C8A84B]/30 bg-gradient-to-b from-[#FAF7EE] to-white p-5 text-center">
                    <p class="text-sm text-gray-400 uppercase tracking-wide mb-2 font-semibold">Ukuran</p>
                    <p class="text-base font-bold text-[#1A3A2A] leading-tight">{{ $displaySize }}</p>
                </div>
                @endif
                @if($product->color)
                <div class="rounded-2xl border border-[#C8A84B]/30 bg-gradient-to-b from-[#FAF7EE] to-white p-5 text-center">
                    <p class="text-sm text-gray-400 uppercase tracking-wide mb-2 font-semibold">Warna</p>
                    <p class="text-base font-bold text-[#1A3A2A] leading-tight">{{ $product->color }}</p>
                </div>
                @endif
            </div>

            {{-- Specs Table --}}
            <div class="rounded-2xl border border-gray-100 overflow-hidden mb-10">
                <div class="px-6 py-4 bg-[#1A3A2A]">
                    <p class="text-sm font-bold text-[#C8A84B] uppercase tracking-widest">Informasi Produk</p>
                </div>
                <div class="divide-y divide-gray-50">
                    @foreach([
                        ['label' => 'Kategori', 'value' => $product->category->name],
                        ['label' => 'Warna',    'value' => $product->color ?: '-'],
                        ['label' => 'Bahan',    'value' => $displayMaterial ?: '-'],
                        ['label' => 'Ukuran',   'value' => $displaySize ?: '-'],
                        ['label' => 'Stok',     'value' => $product->stock > 0 ? 'Tersedia' : 'Habis'],
                    ] as $spec)
                    <div class="flex items-center px-6 py-4">
                        <span class="w-32 text-sm text-gray-400 uppercase tracking-wide flex-shrink-0 font-semibold">{{ $spec['label'] }}</span>
                        <span class="text-gray-300 mr-4 text-base">—</span>
                        <span class="text-base font-semibold {{ $spec['label'] === 'Stok' && $product->stock > 0 ? 'text-green-600' : 'text-gray-700' }}">
                            {{ $spec['value'] }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Tombol Beli --}}
            <div class="space-y-3">
                <a href="https://s.shopee.co.id/W4B94Z5bt" target="_blank" rel="noopener"
                   class="flex items-center justify-center gap-3 w-full font-bold py-4 rounded-xl transition-colors text-lg text-white"
                   style="background:#EE4D2D">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2a5 5 0 015 5v.5h2.5A1.5 1.5 0 0121 9v11a1.5 1.5 0 01-1.5 1.5h-15A1.5 1.5 0 013 20V9a1.5 1.5 0 011.5-1.5H7V7a5 5 0 015-5zm0 2a3 3 0 00-3 3v.5h6V7a3 3 0 00-3-3z"/>
                    </svg>
                    Beli di Shopee
                </a>

                <a href="https://www.tiktok.com/@siskacrocodile.2?_r=1&_t=ZS-975yxxIadfg" target="_blank" rel="noopener"
                   class="flex items-center justify-center gap-3 w-full bg-gray-900 hover:bg-black text-white font-bold py-4 rounded-xl transition-colors text-lg">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.28 8.28 0 004.84 1.54V6.77a4.85 4.85 0 01-1.07-.08z"/>
                    </svg>
                    Beli di TikTok Shop
                </a>

                <a href="https://wa.me/6285891056675?text={{ urlencode('Halo Siska Croco Jaya, saya ingin tanya tentang produk: ' . $product->name) }}"
                   target="_blank" rel="noopener"
                   class="flex items-center justify-center gap-3 w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-xl transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z"/>
                        <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.557 4.126 1.533 5.864L.057 23.571a.5.5 0 00.61.61l5.695-1.476A11.953 11.953 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.006-1.372l-.358-.214-3.716.964.988-3.617-.234-.372A9.818 9.818 0 1112 21.818z"/>
                    </svg>
                    Tanya via WhatsApp (CS)
                </a>
            </div>

            {{-- Trust Badges --}}
            <div class="mt-8 grid grid-cols-3 gap-4">
                <div class="flex flex-col items-center gap-2 p-5 bg-gray-50 rounded-2xl text-center">
                    <svg class="w-7 h-7 text-[#1A3A2A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <span class="text-sm text-gray-600 font-semibold leading-tight">Garansi Pengiriman Selama 1 Bulan</span>
                </div>
                <div class="flex flex-col items-center gap-2 p-5 bg-gray-50 rounded-2xl text-center">
                    <svg class="w-7 h-7 text-[#1A3A2A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                    </svg>
                    <span class="text-sm text-gray-600 font-semibold leading-tight">Free Ongkir</span>
                </div>
                <div class="flex flex-col items-center gap-2 p-5 bg-gray-50 rounded-2xl text-center">
                    <svg class="w-7 h-7 text-[#1A3A2A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                    </svg>
                    <span class="text-sm text-gray-600 font-semibold leading-tight">100% Asli</span>
                </div>
            </div>

            <p class="text-sm text-gray-400 mt-5 text-center">
                Pemesanan melalui Shopee atau TikTok Shop.
            </p>
        </div>
    </div>

    {{-- Ulasan Customer --}}
    <div class="mt-16 pt-10 border-t border-gray-100">
        <h2 class="font-display text-3xl font-bold text-gray-900 mb-2">Ulasan Customer</h2>
        @if($product->reviews->isNotEmpty())
        <div class="flex items-center gap-3 mb-6">
            <span class="text-4xl font-bold text-[#1A3A2A]">{{ number_format($product->average_rating, 1) }}</span>
            <div>
                <div class="flex gap-1 mb-1">
                    @for($i=1;$i<=5;$i++)
                    <svg width="18" height="18" viewBox="0 0 24 24"
                         fill="{{ $i <= round($product->average_rating) ? '#F59E0B' : '#E5E7EB' }}"
                         stroke="{{ $i <= round($product->average_rating) ? '#F59E0B' : '#D1D5DB' }}"
                         stroke-width="1">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    @endfor
                </div>
                <span class="text-sm text-gray-500">{{ $product->reviews->count() }} ulasan</span>
            </div>
        </div>
        <div class="space-y-4 mb-10">
            @foreach($product->reviews as $review)
            <div class="bg-gray-50 rounded-2xl p-5">
                <div class="flex items-center justify-between mb-2">
                    <span class="font-semibold text-gray-800">{{ $review->name }}</span>
                    <span class="text-sm text-gray-400">{{ $review->created_at->format('d M Y') }}</span>
                </div>
                <div class="flex gap-1 mb-2">
                    @for($i=1;$i<=5;$i++)
                    <svg width="16" height="16" viewBox="0 0 24 24"
                         fill="{{ $i <= $review->rating ? '#F59E0B' : '#E5E7EB' }}"
                         stroke="{{ $i <= $review->rating ? '#F59E0B' : '#D1D5DB' }}"
                         stroke-width="1">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    @endfor
                </div>
                <p class="text-gray-600 text-sm leading-relaxed">{{ $review->comment }}</p>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-gray-400 italic mb-8">Belum ada ulasan untuk produk ini. Jadilah yang pertama!</p>
        @endif

        {{-- Form Ulasan --}}
        <div class="bg-[#F7F4EE] rounded-2xl p-6 border border-[#C8A84B]/20">
            <h3 class="font-semibold text-lg text-[#1A3A2A] mb-4">Tulis Ulasan</h3>
            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-4 text-sm">{{ session('success') }}</div>
            @endif
            <form method="POST" action="{{ route('review.store', $product) }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kamu</label>
                    <input type="text" name="name" required maxlength="100"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A3A2A]/30 bg-white"
                        placeholder="Nama kamu...">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                    <div class="flex gap-2 text-2xl" id="star-container">
                        @for($i=1;$i<=5;$i++)
                        <button type="button" onclick="setRating({{ $i }})" class="star-btn transition-transform hover:scale-110" data-val="{{ $i }}" style="color:#d1d5db">★</button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="rating-input" value="5">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Komentar</label>
                    <textarea name="comment" required maxlength="1000" rows="4"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A3A2A]/30 bg-white resize-none"
                        placeholder="Bagikan pengalamanmu dengan produk ini..."></textarea>
                </div>
                <button type="submit"
                    class="bg-[#1A3A2A] hover:bg-[#2d6a4f] text-white font-semibold px-6 py-2.5 rounded-xl transition-colors text-sm">
                    Kirim Ulasan
                </button>
            </form>
        </div>
    </div>

    {{-- Related Products --}}
    @if($related->isNotEmpty())
        <div class="mt-20 pt-12 border-t border-gray-100">
            <h2 class="font-display text-4xl font-bold text-gray-900 mb-8">Produk Serupa</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($related as $rel)
                    <div class="relative bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-lg transition-all duration-300">
                        <a href="{{ route('product.show', $rel->slug) }}" class="block relative overflow-hidden">
                            <img src="{{ Storage::url($rel->main_image) }}" alt="{{ $rel->name }}"
                                 class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-400" loading="lazy">
                            <div class="absolute top-3 left-3 flex flex-col gap-1.5">
                                @if($rel->is_new)
                                    <span class="bg-[#1A3A2A] text-white text-xs font-bold px-3 py-1 rounded-full">TERBARU</span>
                                @endif
                                @if($rel->is_promo)
                                    <span class="bg-[#C8A84B] text-[#0F2318] text-xs font-bold px-3 py-1 rounded-full">PROMO</span>
                                @endif
                            </div>
                            {{-- Tombol favorit --}}
                            <button
                                data-fav-id="{{ $rel->id }}"
                                onclick="event.preventDefault(); toggleFav('{{ $rel->id }}','{{ addslashes($rel->name) }}','{{ $rel->formatted_price }}','{{ Storage::url($rel->main_image) }}','{{ route('product.show', $rel->slug) }}')"
                                class="absolute top-3 right-3 w-9 h-9 rounded-full flex items-center justify-center bg-white/80 backdrop-blur-sm hover:bg-white shadow-sm transition-all duration-200 hover:scale-110 z-10"
                                aria-label="Simpan ke favorit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                                     style="transition: fill .2s, stroke .2s;">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            </button>
                        </a>
                        <div class="p-5">
                            <a href="{{ route('product.show', $rel->slug) }}" class="font-semibold text-base text-gray-800 hover:text-[#1A3A2A] line-clamp-2 block mb-2 transition-colors">
                                {{ $rel->name }}
                            </a>
                            <p class="text-gray-900 font-bold text-lg">{{ $rel->formatted_price }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>

@section('scripts')
<script>
function setRating(val) {
    document.getElementById('rating-input').value = val;
    document.querySelectorAll('.star-btn').forEach(btn => {
        btn.style.color = parseInt(btn.dataset.val) <= val ? '#f59e0b' : '#d1d5db';
    });
}
setRating(5);
</script>
@endsection

@endsection