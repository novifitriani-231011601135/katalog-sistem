@extends('admin.layout')

@section('title', 'Edit Kategori')

@section('content')

<div style="margin-bottom:48px;">
    <span class="page-label">Manajemen Kategori</span>
    <h1 class="page-title">Edit Kategori</h1>
</div>

<div class="form-card" style="max-width:760px;">
    <form method="POST" action="{{ route('admin.kategori.update', $kategori) }}">
        @csrf
        @method('PUT')

        {{-- Tipe Kategori --}}
        <div style="margin-bottom:28px;">
            <label class="field-label">Tipe Kategori</label>
            <div style="display:flex;gap:16px;margin-top:10px;">
                <label style="display:flex;align-items:center;gap:10px;cursor:pointer;padding:14px 22px;border-radius:10px;border:2px solid {{ is_null($kategori->parent_id) ? '#c9a84c' : '#e5e7eb' }};background:{{ is_null($kategori->parent_id) ? '#fdf9f0' : '#fff' }};flex:1;transition:all .2s;" id="label-parent">
                    <input type="radio" name="category_type" id="type-parent" value="parent"
                           style="accent-color:#c9a84c;width:18px;height:18px;"
                           {{ is_null($kategori->parent_id) ? 'checked' : '' }}
                           onchange="toggleCategoryType(this.value)">
                    <span>
                        <strong style="display:block;color:#1a1a1a;font-size:14px;letter-spacing:.5px;">KATEGORI UTAMA</strong>
                        <small style="color:#888;font-size:12px;">Contoh: Woman Collection, Men Collection</small>
                    </span>
                </label>
                <label style="display:flex;align-items:center;gap:10px;cursor:pointer;padding:14px 22px;border-radius:10px;border:2px solid {{ !is_null($kategori->parent_id) ? '#c9a84c' : '#e5e7eb' }};background:{{ !is_null($kategori->parent_id) ? '#fdf9f0' : '#fff' }};flex:1;transition:all .2s;" id="label-sub">
                    <input type="radio" name="category_type" id="type-sub" value="sub"
                           style="accent-color:#c9a84c;width:18px;height:18px;"
                           {{ !is_null($kategori->parent_id) ? 'checked' : '' }}
                           onchange="toggleCategoryType(this.value)">
                    <span>
                        <strong style="display:block;color:#1a1a1a;font-size:14px;letter-spacing:.5px;">SUB KATEGORI</strong>
                        <small style="color:#888;font-size:12px;">Contoh: Bags, Accessories, Shoes</small>
                    </span>
                </label>
            </div>
        </div>

        {{-- Dropdown Kategori Induk --}}
        <div id="parent-select-wrap" style="margin-bottom:28px;display:{{ !is_null($kategori->parent_id) ? 'block' : 'none' }};">
            <label class="field-label">Kategori Induk</label>
            <select name="parent_id" class="field-input" id="parent-select"
                    style="appearance:none;-webkit-appearance:none;background-image:url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23888' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E\");background-repeat:no-repeat;background-position:right 16px center;padding-right:44px;cursor:pointer;">
                <option value="">— Pilih Kategori Utama —</option>
                @foreach($parentCategories as $parent)
                    <option value="{{ $parent->id }}" {{ old('parent_id', $kategori->parent_id) == $parent->id ? 'selected' : '' }}>
                        {{ $parent->name }}
                    </option>
                @endforeach
            </select>
            @error('parent_id')
                <small style="color:#ef4444;font-size:12px;margin-top:6px;display:block;">{{ $message }}</small>
            @enderror
        </div>

        {{-- Nama Kategori --}}
        <div style="margin-bottom:36px;">
            <label class="field-label">Nama Kategori</label>
            <input type="text" name="name" class="field-input"
                   value="{{ old('name', $kategori->name) }}" required
                   placeholder="Contoh: Dompet, Tas, Ikat Pinggang, Sepatu">
            @error('name')
                <small style="color:#ef4444;font-size:12px;margin-top:6px;display:block;">{{ $message }}</small>
            @enderror
            <p style="font-size:12px;color:#bbb;margin-top:8px;line-height:1.5;">
                Slug saat ini: <code style="background:#f5f2ec;padding:2px 8px;border-radius:4px;font-size:11px;color:#888;">{{ $kategori->slug }}</code>
            </p>
        </div>

        <div class="form-divider">
            <button type="submit" class="btn-save">Simpan Perubahan →</button>
            <a href="{{ route('admin.kategori.index') }}" class="btn-back">← Kembali ke Daftar</a>
        </div>
    </form>
</div>

<script>
function toggleCategoryType(val) {
    const wrap = document.getElementById('parent-select-wrap');
    const labelParent = document.getElementById('label-parent');
    const labelSub = document.getElementById('label-sub');
    const select = document.getElementById('parent-select');

    if (val === 'sub') {
        wrap.style.display = 'block';
        labelSub.style.borderColor = '#c9a84c';
        labelSub.style.background = '#fdf9f0';
        labelParent.style.borderColor = '#e5e7eb';
        labelParent.style.background = '#fff';
    } else {
        wrap.style.display = 'none';
        select.value = '';
        labelParent.style.borderColor = '#c9a84c';
        labelParent.style.background = '#fdf9f0';
        labelSub.style.borderColor = '#e5e7eb';
        labelSub.style.background = '#fff';
    }
}
</script>

@endsection
