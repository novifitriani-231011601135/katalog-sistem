@extends('admin.layout')

@section('title', 'Kategori')

@section('content')

<div class="d-flex justify-content-between align-items-end" style="margin-bottom:44px;">
    <div>
        <span class="page-label">Manajemen</span>
        <h1 class="page-title mb-0">Kategori</h1>
    </div>
    <a href="{{ route('admin.kategori.create') }}" class="btn-add">+ Tambah Kategori</a>
</div>

@if(session('success'))
    <div class="alert-ok">{{ session('success') }}</div>
@endif

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th style="width:50px;">#</th>
                <th>Nama Kategori</th>
                <th>Slug</th>
                <th style="width:160px;">Jumlah Produk</th>
                <th style="width:160px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($parents as $i => $parent)
                {{-- Baris Kategori Utama --}}
                <tr style="background:#fdf9f0;">
                    <td style="color:#bbb;font-size:13px;font-weight:500;">{{ $i + 1 }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#c9a84c;flex-shrink:0;"></span>
                            <span style="font-weight:700;color:#111;font-size:15px;letter-spacing:.3px;">{{ strtoupper($parent->name) }}</span>
                            @if($parent->children->count() > 0)
                                <span style="font-size:11px;color:#c9a84c;font-weight:600;background:#fef3c7;padding:2px 8px;border-radius:20px;letter-spacing:.3px;">
                                    {{ $parent->children->count() }} sub kategori
                                </span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <code style="font-size:12px;color:#888;background:#f5f2ec;padding:4px 10px;border-radius:6px;font-family:monospace;">{{ $parent->slug }}</code>
                    </td>
                    <td>
                        <span class="badge-count">{{ $parent->products_count }} produk</span>
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.kategori.edit', $parent) }}" class="btn-edit">Edit</a>
                            <form method="POST" action="{{ route('admin.kategori.destroy', $parent) }}">
                                @csrf @method('DELETE')
                                <button class="btn-del" onclick="return confirm('Hapus kategori ini beserta semua sub kategorinya?')">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>

                {{-- Baris Sub Kategori --}}
                @foreach($parent->children as $child)
                <tr>
                    <td></td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;padding-left:20px;">
                            <span style="color:#ccc;font-size:16px;line-height:1;">└</span>
                            <span style="font-weight:500;color:#444;font-size:14px;">{{ $child->name }}</span>
                        </div>
                    </td>
                    <td>
                        <code style="font-size:12px;color:#888;background:#f5f2ec;padding:4px 10px;border-radius:6px;font-family:monospace;">{{ $child->slug }}</code>
                    </td>
                    <td>
                        <span class="badge-count">{{ $child->products_count }} produk</span>
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.kategori.edit', $child) }}" class="btn-edit">Edit</a>
                            <form method="POST" action="{{ route('admin.kategori.destroy', $child) }}">
                                @csrf @method('DELETE')
                                <button class="btn-del" onclick="return confirm('Hapus sub kategori ini?')">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach

            @empty
            <tr>
                <td colspan="5" style="text-align:center;padding:60px 20px;color:#ccc;font-size:14px;">
                    Belum ada kategori yang ditambahkan
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
