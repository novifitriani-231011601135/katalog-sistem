@extends('layouts.app')

@section('title', 'Profil - Siska Croco Jaya')

@section('content')

{{-- Page Header --}}
<div class="bg-[#1A3A2A] text-white py-20">
    <div class="max-w-screen-2xl mx-auto px-6 sm:px-10 lg:px-16">
        <nav class="flex items-center gap-2 text-base text-gray-400 mb-5">
            <a href="{{ route('home') }}" class="hover:text-[#C8A84B]">Home</a>
            <span>/</span>
            <span class="text-[#C8A84B]">Profil</span>
        </nav>
        <h1 class="font-display text-6xl font-bold text-white leading-tight">Siska Croco Jaya</h1>
        <p class="text-gray-300 mt-4 text-xl max-w-2xl">Brand lokal produk kulit buaya asli berkualitas premium</p>
    </div>
</div>

<div class="max-w-screen-2xl mx-auto px-6 sm:px-10 lg:px-16 py-20">

    {{-- About section --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center mb-24">
        {{-- Text --}}
        <div>
            <div class="inline-block bg-[#C8A84B]/15 text-[#A88A3A] text-sm font-bold tracking-widest uppercase px-5 py-2 rounded-full mb-6">
                Tentang Kami
            </div>
            <h2 class="font-display text-5xl font-bold text-gray-900 leading-tight mb-8">
                Kualitas Premium<br>
                <span class="text-[#1A3A2A]">Dari Buaya Asli</span>
            </h2>
            <div class="space-y-5 text-gray-600 leading-relaxed text-lg">
                <p class="font-bold text-gray-800 text-xl">
                    Hello, Beloved Customer Siska Crocodile! 🐊✨
                </p>
                <p>
                    Selamat datang di <strong class="text-gray-900">Siska Crocodile</strong>, tempat di mana produk fashion berbahan kulit premium hadir dengan kualitas terbaik, desain elegan, dan detail yang dibuat dengan penuh perhatian.
                </p>
                <p>
                    Kami juga bangga mendukung masyarakat sekitar, khususnya Merauke, melalui pemberdayaan tenaga kerja lokal.
                </p>
                <p>
                    Temukan koleksi terbaik kami dan pilih produk favoritmu dengan mudah melalui katalog ini.
                </p>
            </div>
        </div>

        {{-- Visual side --}}
        <div class="relative">
            <div class="bg-[#0F2318] rounded-3xl text-center text-white relative overflow-hidden"
                 style="background-image: radial-gradient(circle, rgba(200,168,75,0.12) 1px, transparent 1px); background-size: 22px 22px;">

                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-80 h-40 rounded-full opacity-20"
                     style="background: radial-gradient(ellipse, #C8A84B, transparent 70%);"></div>

                <div class="relative z-10 px-12 pt-16 pb-14">
                    {{-- Logo circle --}}
                    <div class="w-40 h-40 mx-auto mb-8 rounded-full flex items-center justify-center"
                         style="box-shadow: 0 0 0 2px rgba(200,168,75,0.5), 0 0 0 6px rgba(200,168,75,0.1), 0 0 32px rgba(200,168,75,0.2);">
                        <div class="w-36 h-36 rounded-full overflow-hidden border border-[#C8A84B]/40">
                            <img src="/images/logo.jpg" alt="Siska Croco Jaya"
                                 class="w-full h-full object-cover"
                                 style="filter: brightness(1.1) contrast(1.05);">
                        </div>
                    </div>

                    {{-- Brand name --}}
                    <p class="font-display text-5xl font-bold text-[#C8A84B] tracking-[0.08em] mb-2"
                       style="text-shadow: 0 0 20px rgba(200,168,75,0.4);">SISKA</p>
                    <p class="text-sm font-semibold tracking-[0.4em] text-white/60 mb-10 uppercase">CROCO JAYA</p>

                    {{-- Divider --}}
                    <div class="flex items-center gap-3 mb-10">
                        <div class="flex-1 h-px bg-gradient-to-r from-transparent to-[#C8A84B]/40"></div>
                        <div class="w-2 h-2 rounded-full bg-[#C8A84B]/60"></div>
                        <div class="flex-1 h-px bg-gradient-to-l from-transparent to-[#C8A84B]/40"></div>
                    </div>

                    {{-- Stats --}}
                    <div class="grid grid-cols-3 gap-6 text-center">
                        <div>
                            <p class="font-display text-4xl font-bold text-[#C8A84B]">100%</p>
                            <p class="text-sm text-white/50 mt-2 uppercase tracking-wider">Kulit Asli</p>
                        </div>
                        <div class="border-x border-[#C8A84B]/15">
                            <p class="font-display text-4xl font-bold text-[#C8A84B]">50+</p>
                            <p class="text-sm text-white/50 mt-2 uppercase tracking-wider">Produk</p>
                        </div>
                        <div>
                            <p class="font-display text-4xl font-bold text-[#C8A84B]">1K+</p>
                            <p class="text-sm text-white/50 mt-2 uppercase tracking-wider">Pelanggan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Value Propositions --}}
    <div class="mb-24">
        <div class="text-center mb-14">
            <h2 class="font-display text-5xl font-bold text-gray-900 mb-5">Mengapa Memilih Kami?</h2>
            <p class="text-gray-500 max-w-xl mx-auto text-lg">Kami mengutamakan kepuasan pelanggan dengan standar kualitas tertinggi</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach([
                [
                    'title' => 'Kualitas Premium',
                    'desc'  => 'Menggunakan kulit buaya asli pilihan terbaik yang diproses dengan standar kualitas tinggi untuk ketahanan dan keindahan jangka panjang.',
                    'icon'  => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z',
                ],
                [
                    'title' => 'Desain Eksklusif',
                    'desc'  => 'Setiap produk dirancang dengan detail yang modern dan elegan, memadukan keanggunan tradisional dengan sentuhan kontemporer yang stylish.',
                    'icon'  => 'M4.098 19.902a3.75 3.75 0 005.304 0l6.401-6.402M6.75 21A3.75 3.75 0 013 17.25V4.125C3 3.504 3.504 3 4.125 3h5.25c.621 0 1.125.504 1.125 1.125v4.072M6.75 21a3.75 3.75 0 003.75-3.75V8.197M6.75 21h13.125c.621 0 1.125-.504 1.125-1.125v-5.25c0-.621-.504-1.125-1.125-1.125h-4.072M10.5 8.197l2.88-2.88c.438-.439 1.15-.439 1.59 0l3.712 3.713c.44.44.44 1.152 0 1.59l-2.879 2.88M6.75 17.25h.008v.008H6.75v-.008z',
                ],
                [
                    'title' => 'Garansi Produk',
                    'desc'  => 'Kami memberikan garansi untuk setiap produk yang Anda beli. Kepuasan pelanggan adalah prioritas utama kami dalam setiap transaksi.',
                    'icon'  => 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z',
                ],
            ] as $item)
                <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-16 h-16 rounded-2xl bg-[#1A3A2A]/10 flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-[#1A3A2A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $item['icon'] }}"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 text-2xl mb-4">{{ $item['title'] }}</h3>
                    <p class="text-gray-500 text-base leading-relaxed">{{ $item['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>

    {{-- CTA --}}
    <div class="bg-[#1A3A2A] rounded-3xl p-16 text-center text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-10"
             style="background-image: radial-gradient(circle, #C8A84B 1px, transparent 1px); background-size: 28px 28px;"></div>
        <div class="relative z-10">
            <h2 class="font-display text-5xl font-bold mb-5">Tertarik dengan Produk Kami?</h2>
            <p class="text-gray-300 mb-10 max-w-xl mx-auto text-lg">Kunjungi katalog produk kami atau hubungi langsung via WhatsApp untuk informasi lebih lanjut</p>
            <div class="flex flex-wrap gap-5 justify-center">
                <a href="{{ route('katalog') }}"
                   class="bg-[#C8A84B] hover:bg-[#A88A3A] text-[#0F2318] font-bold px-10 py-4 rounded-full transition-colors text-lg">
                    Lihat Katalog Produk
                </a>
                <a href="https://wa.me/6285891056675?text=Halo%20Siska%20Croco%20Jaya%2C%20saya%20ingin%20bertanya%20tentang%20produk" target="_blank" rel="noopener"
                   class="bg-white/10 hover:bg-white/20 text-white font-bold px-10 py-4 rounded-full transition-colors text-lg border border-white/30">
                    Hubungi via WhatsApp
                </a>
            </div>
        </div>
    </div>

</div>

@endsection
