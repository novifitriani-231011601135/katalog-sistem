@extends('admin.layout')
@section('title', 'Kelola Banner')

@section('content')
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem">
    <h1 style="font-size:1.4rem;font-weight:700;color:#1A3A2A">Kelola Banner</h1>
    <a href="{{ route('admin.banner.create') }}" style="background:#1A3A2A;color:white;padding:.5rem 1.1rem;border-radius:8px;text-decoration:none;font-size:.9rem">+ Tambah Banner</a>
</div>

@if(session('success'))
<div style="background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;padding:.75rem 1rem;border-radius:8px;margin-bottom:1rem">{{ session('success') }}</div>
@endif

<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:1rem">
    @forelse($banners as $banner)
    <div style="background:#fff;border-radius:12px;box-shadow:0 1px 4px rgba(0,0,0,.08);overflow:hidden">
        <img src="{{ Storage::url($banner->image) }}" style="width:100%;height:160px;object-fit:cover">
        <div style="padding:1rem">
            <div style="font-weight:600;color:#1A3A2A;margin-bottom:.3rem">{{ $banner->title }}</div>
            <div style="font-size:.8rem;color:#6b7280;margin-bottom:.75rem">
                Urutan: {{ $banner->sort_order }} &nbsp;|&nbsp;
                @if($banner->is_active)
                    <span style="color:#059669">Aktif</span>
                @else
                    <span style="color:#dc2626">Nonaktif</span>
                @endif
            </div>
            <div style="display:flex;gap:.5rem">
                <a href="{{ route('admin.banner.edit', $banner) }}" style="background:#f3f4f6;color:#374151;padding:.3rem .7rem;border-radius:6px;text-decoration:none;font-size:.82rem">Edit</a>
                <form method="POST" action="{{ route('admin.banner.destroy', $banner) }}" onsubmit="return confirm('Hapus banner ini?')">
                    @csrf @method('DELETE')
                    <button style="background:#dc2626;color:white;border:none;padding:.3rem .7rem;border-radius:6px;cursor:pointer;font-size:.82rem">Hapus</button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <p style="color:#9ca3af">Belum ada banner.</p>
    @endforelse
</div>
@endsection
