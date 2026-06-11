@extends('admin.layout')
@section('title', 'Edit Banner')

@section('content')
<div style="max-width:600px">
    <h1 style="font-size:1.4rem;font-weight:700;color:#1A3A2A;margin-bottom:1.5rem">Edit Banner</h1>

    <form method="POST" action="{{ route('admin.banner.update', $banner) }}" enctype="multipart/form-data" style="background:#fff;border-radius:12px;padding:1.5rem;box-shadow:0 1px 4px rgba(0,0,0,.08)">
        @csrf @method('PUT')
        <div style="margin-bottom:1rem">
            <label style="display:block;font-weight:600;margin-bottom:.4rem;color:#374151">Judul Banner</label>
            <input type="text" name="title" value="{{ old('title', $banner->title) }}" required style="width:100%;border:1px solid #d1d5db;border-radius:8px;padding:.6rem .8rem;font-size:.9rem;box-sizing:border-box">
        </div>
        <div style="margin-bottom:1rem">
            <label style="display:block;font-weight:600;margin-bottom:.4rem;color:#374151">Gambar Banner (biarkan kosong jika tidak diubah)</label>
            <img src="{{ Storage::url($banner->image) }}" style="height:100px;border-radius:6px;margin-bottom:.5rem;display:block">
            <input type="file" name="image" accept="image/*" style="width:100%;border:1px solid #d1d5db;border-radius:8px;padding:.6rem .8rem;font-size:.9rem;box-sizing:border-box">
        </div>
        <div style="margin-bottom:1rem">
            <label style="display:block;font-weight:600;margin-bottom:.4rem;color:#374151">Link (opsional)</label>
            <input type="url" name="link" value="{{ old('link', $banner->link) }}" placeholder="https://..." style="width:100%;border:1px solid #d1d5db;border-radius:8px;padding:.6rem .8rem;font-size:.9rem;box-sizing:border-box">
        </div>
        <div style="margin-bottom:1rem">
            <label style="display:block;font-weight:600;margin-bottom:.4rem;color:#374151">Urutan</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $banner->sort_order) }}" style="width:100%;border:1px solid #d1d5db;border-radius:8px;padding:.6rem .8rem;font-size:.9rem;box-sizing:border-box">
        </div>
        <div style="margin-bottom:1.5rem;display:flex;align-items:center;gap:.5rem">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ $banner->is_active ? 'checked' : '' }}>
            <label for="is_active" style="color:#374151">Aktifkan banner ini</label>
        </div>
        <div style="display:flex;gap:.75rem">
            <button type="submit" style="background:#1A3A2A;color:white;border:none;padding:.6rem 1.5rem;border-radius:8px;cursor:pointer;font-size:.9rem">Update</button>
            <a href="{{ route('admin.banner.index') }}" style="background:#f3f4f6;color:#374151;padding:.6rem 1.2rem;border-radius:8px;text-decoration:none;font-size:.9rem">Batal</a>
        </div>
    </form>
</div>
@endsection
