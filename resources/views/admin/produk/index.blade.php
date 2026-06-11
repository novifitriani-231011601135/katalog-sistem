@extends('admin.layout')

@section('title', 'Produk')

@section('content')

<div class="d-flex justify-content-between align-items-end" style="margin-bottom:44px;">
    <div>
        <span class="page-label">Manajemen</span>
        <h1 class="page-title mb-0">Produk</h1>
    </div>
    <a href="{{ route('admin.produk.create') }}" class="btn-add">+ Tambah Produk</a>
</div>

@if(session('success'))
    <div class="alert-ok">{{ session('success') }}</div>
@endif

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th style="width:52px;">#</th>
                <th style="width:104px;">Gambar</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th style="width:100px;">Stok</th>
                <th style="width:160px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $i => $product)
            <tr>
                <td style="color:#bbb;font-size:13px;font-weight:500;">{{ $i + 1 }}</td>
                <td>
                    @if($product->main_image)
                        <img src="{{ Storage::url($product->main_image) }}"
                             alt="{{ $product->name }}"
                             class="table-thumb">
                    @else
                        <div class="table-thumb-placeholder">🐊</div>
                    @endif
                </td>
                <td>
                    <div style="font-weight:600;color:#111;font-size:14px;line-height:1.4;">{{ $product->name }}</div>
                    @if($product->color)
                        <div style="font-size:12px;color:#aaa;margin-top:4px;font-weight:400;">{{ $product->color }}</div>
                    @endif
                    @if($product->is_new || $product->is_promo)
                        <div style="margin-top:6px;display:flex;gap:5px;flex-wrap:wrap;">
                            @if($product->is_new)
                                <span style="font-size:10px;font-weight:700;letter-spacing:0.8px;background:#0a1a10;color:rgba(201,168,76,0.8);padding:2px 8px;border-radius:4px;">BARU</span>
                            @endif
                            @if($product->is_promo)
                                <span style="font-size:10px;font-weight:700;letter-spacing:0.8px;background:rgba(201,168,76,0.15);color:#c9a84c;padding:2px 8px;border-radius:4px;">PROMO</span>
                            @endif
                        </div>
                    @endif
                </td>
                <td>
                    <span class="badge-cat">{{ $product->category->name ?? '—' }}</span>
                </td>
                <td style="font-weight:700;color:#0a1a10;font-size:14px;white-space:nowrap;">
                    {{ $product->formatted_price }}
                </td>
                <td>
                    @if($product->stock > 0)
                        <span class="badge-stock-ok">{{ $product->stock }}</span>
                    @else
                        <span class="badge-stock-empty">0</span>
                    @endif
                </td>
                <td>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.produk.edit', $product) }}" class="btn-edit">Edit</a>
                        <form method="POST" action="{{ route('admin.produk.destroy', $product) }}">
                            @csrf @method('DELETE')
                            <button class="btn-del" onclick="return confirm('Hapus produk ini?')">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;padding:60px 20px;color:#ccc;font-size:14px;">
                    Belum ada produk yang ditambahkan
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
