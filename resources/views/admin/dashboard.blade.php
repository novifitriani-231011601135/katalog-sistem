@extends('admin.layout')
@section('title', 'Dashboard')

@section('content')
@php
    $totalProduk    = \App\Models\Product::count();
    $totalKategori  = \App\Models\Category::count();
    $totalUlasan    = \App\Models\Review::count();
    $ulasanPending  = \App\Models\Review::where('is_approved', false)->count();
    $totalBanner    = \App\Models\Banner::where('is_active', true)->count();
    $produkBaru     = \App\Models\Product::where('is_new', true)->count();
    $produkFeatured = \App\Models\Product::where('is_featured', true)->count();
    $produkTerbaru  = \App\Models\Product::with('category')->latest()->limit(5)->get();
    $ulasanTerbaru  = \App\Models\Review::with('product')->where('is_approved', false)->latest()->limit(3)->get();

    $days   = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    $months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    $now     = now();
    $tanggal = $days[$now->dayOfWeek] . ', ' . $now->day . ' ' . $months[$now->month - 1] . ' ' . $now->year;
@endphp

{{-- Greeting --}}
<div style="background:#1A3A2A;border-radius:14px;padding:1.5rem 1.75rem;margin-bottom:1.25rem;display:flex;align-items:center;justify-content:space-between">
    <div>
        <div style="font-size:1.5rem;margin-bottom:.25rem">👋</div>
        <div style="font-size:1.1rem;font-weight:600;color:#fff">Selamat datang, Team Admin!</div>
        <div style="font-size:.88rem;color:rgba(255,255,255,.55);margin-top:3px">Semoga harimu selalu baik!</div>
        <div style="font-size:.8rem;color:#C8A84B;margin-top:8px;display:flex;align-items:center;gap:5px">
            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            {{ $tanggal }}
        </div>
    </div>
    <svg width="64" height="64" fill="none" stroke="#C8A84B" viewBox="0 0 24 24" stroke-width="1" style="opacity:.2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
    </svg>
</div>

{{-- Notif ulasan pending --}}
@if($ulasanPending > 0)
<div style="background:#fef3c7;border:1px solid #fbbf24;border-radius:10px;padding:.875rem 1.25rem;display:flex;align-items:center;gap:.75rem;margin-bottom:1.25rem">
    <svg width="18" height="18" fill="none" stroke="#d97706" viewBox="0 0 24 24" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <span style="color:#92400e;font-size:.88rem;flex:1">Ada <strong>{{ $ulasanPending }} ulasan</strong> menunggu persetujuan kamu.</span>
    <a href="{{ route('admin.ulasan.index') }}" style="background:#d97706;color:white;padding:.3rem .9rem;border-radius:6px;font-size:.8rem;text-decoration:none;white-space:nowrap">Lihat sekarang</a>
</div>
@endif

{{-- Statistik --}}
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(148px,1fr));gap:.75rem;margin-bottom:1.25rem">
    @foreach([
        ['label'=>'Total Produk',   'value'=>$totalProduk,    'bg'=>'#E8F5EE', 'color'=>'#1A3A2A', 'd'=>'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10'],
        ['label'=>'Kategori',       'value'=>$totalKategori,  'bg'=>'#EEF2FF', 'color'=>'#4338CA', 'd'=>'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z'],
        ['label'=>'Produk Baru',    'value'=>$produkBaru,     'bg'=>'#EFF6FF', 'color'=>'#2563EB', 'd'=>'M12 6v6m0 0v6m0-6h6m-6 0H6'],
        ['label'=>'Terlaris',       'value'=>$produkFeatured, 'bg'=>'#FEF3C7', 'color'=>'#D97706', 'd'=>'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z'],
        ['label'=>'Total Ulasan',   'value'=>$totalUlasan,    'bg'=>'#F3E8FF', 'color'=>'#7C3AED', 'd'=>'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z'],
        ['label'=>'Ulasan Pending', 'value'=>$ulasanPending,  'bg'=>'#FEE2E2', 'color'=>'#DC2626', 'd'=>'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label'=>'Banner Aktif',   'value'=>$totalBanner,    'bg'=>'#ECFDF5', 'color'=>'#059669', 'd'=>'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
    ] as $s)
    <div style="background:#fff;border-radius:12px;padding:1rem;border:0.5px solid #f3f4f6;display:flex;align-items:center;gap:.75rem">
        <div style="width:40px;height:40px;border-radius:10px;background:{{ $s['bg'] }};display:flex;align-items:center;justify-content:center;flex-shrink:0">
            <svg width="20" height="20" fill="none" stroke="{{ $s['color'] }}" viewBox="0 0 24 24" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $s['d'] }}"/>
            </svg>
        </div>
        <div>
            <div style="font-size:1.5rem;font-weight:700;color:#1A3A2A;line-height:1">{{ $s['value'] }}</div>
            <div style="font-size:.73rem;color:#9ca3af;margin-top:3px">{{ $s['label'] }}</div>
        </div>
    </div>
    @endforeach
</div>

{{-- Quick Actions --}}
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:.75rem;margin-bottom:1.25rem">
    @foreach([
        ['label'=>'Tambah Produk', 'href'=>route('admin.produk.create'),  'bg'=>'#E8F5EE', 'color'=>'#1A3A2A', 'd'=>'M12 6v6m0 0v6m0-6h6m-6 0H6'],
        ['label'=>'Tambah Banner', 'href'=>route('admin.banner.create'),  'bg'=>'#EFF6FF', 'color'=>'#2563EB', 'd'=>'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
        ['label'=>'Kelola Ulasan', 'href'=>route('admin.ulasan.index'),   'bg'=>'#F3E8FF', 'color'=>'#7C3AED', 'd'=>'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z'],
    ] as $a)
    <a href="{{ $a['href'] }}"
       style="background:#fff;border-radius:12px;padding:.875rem 1rem;border:0.5px solid #f3f4f6;display:flex;align-items:center;gap:.75rem;text-decoration:none;transition:all .2s"
       onmouseover="this.style.borderColor='#1A3A2A';this.style.background='#f9fafb'"
       onmouseout="this.style.borderColor='#f3f4f6';this.style.background='#fff'">
        <div style="width:36px;height:36px;border-radius:9px;background:{{ $a['bg'] }};display:flex;align-items:center;justify-content:center;flex-shrink:0">
            <svg width="18" height="18" fill="none" stroke="{{ $a['color'] }}" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $a['d'] }}"/>
            </svg>
        </div>
        <span style="font-size:.88rem;font-weight:500;color:#1A3A2A">{{ $a['label'] }}</span>
        <svg style="margin-left:auto" width="14" height="14" fill="none" stroke="#d1d5db" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
    </a>
    @endforeach
</div>

{{-- Produk terbaru + Ulasan pending --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem">

    {{-- Produk terbaru --}}
    <div style="background:#fff;border-radius:12px;padding:1.25rem;border:0.5px solid #f3f4f6">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem">
            <span style="font-size:.9rem;font-weight:600;color:#1A3A2A">Produk Terbaru</span>
            <a href="{{ route('admin.produk.index') }}" style="font-size:.75rem;color:#C8A84B;text-decoration:none;font-weight:500">Lihat semua →</a>
        </div>
        @forelse($produkTerbaru as $p)
        <div style="display:flex;align-items:center;gap:.75rem;padding:.6rem 0;border-bottom:0.5px solid #f9fafb">
            <div style="width:36px;height:36px;border-radius:8px;background:#f3f4f6;overflow:hidden;flex-shrink:0">
                @if($p->main_image)
                <img src="{{ Storage::url($p->main_image) }}" style="width:100%;height:100%;object-fit:cover">
                @else
                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center">
                    <svg width="16" height="16" fill="none" stroke="#9ca3af" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                    </svg>
                </div>
                @endif
            </div>
            <div style="flex:1;min-width:0">
                <div style="font-size:.83rem;font-weight:500;color:#1A3A2A;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $p->name }}</div>
                <div style="font-size:.74rem;color:#9ca3af;margin-top:1px">{{ $p->category->name ?? '-' }} · {{ $p->formatted_price }}</div>
            </div>
            <div style="display:flex;gap:3px;flex-shrink:0">
                @if($p->is_new)<span style="background:#E8F5EE;color:#1A3A2A;font-size:.68rem;padding:2px 7px;border-radius:20px;font-weight:500">Baru</span>@endif
                @if($p->is_featured)<span style="background:#FEF3C7;color:#92400e;font-size:.68rem;padding:2px 7px;border-radius:20px;font-weight:500">Terlaris</span>@endif
            </div>
        </div>
        @empty
        <div style="text-align:center;padding:1.5rem 0">
            <svg width="32" height="32" fill="none" stroke="#d1d5db" viewBox="0 0 24 24" stroke-width="1.5" style="margin:0 auto .5rem">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
            </svg>
            <p style="font-size:.82rem;color:#9ca3af">Belum ada produk.</p>
        </div>
        @endforelse
    </div>

    {{-- Ulasan pending --}}
    <div style="background:#fff;border-radius:12px;padding:1.25rem;border:0.5px solid #f3f4f6">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem">
            <span style="font-size:.9rem;font-weight:600;color:#1A3A2A">Ulasan Menunggu</span>
            <a href="{{ route('admin.ulasan.index') }}" style="font-size:.75rem;color:#C8A84B;text-decoration:none;font-weight:500">Lihat semua →</a>
        </div>
        @forelse($ulasanTerbaru as $u)
        <div style="padding:.6rem 0;border-bottom:0.5px solid #f9fafb">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:3px">
                <span style="font-size:.83rem;font-weight:500;color:#1A3A2A">{{ $u->name }}</span>
                <span style="display:flex;gap:1px">
                    @for($i=1;$i<=5;$i++)
                    <svg width="12" height="12" viewBox="0 0 24 24"
                         fill="{{ $i <= $u->rating ? '#F59E0B' : '#E5E7EB' }}"
                         stroke="{{ $i <= $u->rating ? '#F59E0B' : '#D1D5DB' }}"
                         stroke-width="1">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    @endfor
                </span>
            </div>
            <div style="font-size:.78rem;color:#9ca3af;margin-bottom:6px;line-height:1.4">{{ Str::limit($u->comment, 55) }}</div>
            <div style="display:flex;gap:4px">
                <form method="POST" action="{{ route('admin.ulasan.approve', $u) }}" style="margin:0">
                    @csrf @method('PATCH')
                    <button style="background:#d1fae5;color:#065f46;border:none;padding:3px 10px;border-radius:6px;cursor:pointer;font-size:.75rem;font-weight:500">Setujui</button>
                </form>
                <form method="POST" action="{{ route('admin.ulasan.destroy', $u) }}" style="margin:0" onsubmit="return confirm('Hapus ulasan ini?')">
                    @csrf @method('DELETE')
                    <button style="background:#fee2e2;color:#991b1b;border:none;padding:3px 10px;border-radius:6px;cursor:pointer;font-size:.75rem;font-weight:500">Hapus</button>
                </form>
            </div>
        </div>
        @empty
        <div style="text-align:center;padding:1.5rem 0">
            <svg width="32" height="32" fill="none" stroke="#d1d5db" viewBox="0 0 24 24" stroke-width="1.5" style="margin:0 auto .5rem">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            <p style="font-size:.82rem;color:#9ca3af">Tidak ada ulasan pending.</p>
        </div>
        @endforelse
    </div>

</div>
@endsection