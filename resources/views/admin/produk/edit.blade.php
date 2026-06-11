@extends('admin.layout')

@section('title', 'Edit Produk')

@section('content')

<div style="margin-bottom:48px;">
    <span class="page-label">Manajemen Produk</span>
    <h1 class="page-title">Edit Produk</h1>
</div>

<div class="form-card">
    <form method="POST" action="{{ route('admin.produk.update', $produk) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-5">

            <div class="col-md-6">
                <label class="field-label">Nama Produk</label>
                <input type="text" name="name" class="field-input"
                       value="{{ old('name', $produk->name) }}" required>
                @error('name')
                    <small style="color:#ef4444;font-size:12px;margin-top:6px;display:block;">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="field-label">Kategori</label>
                <select name="category_id" class="field-input" required>
                    <option value="">— Pilih Kategori —</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $produk->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <small style="color:#ef4444;font-size:12px;margin-top:6px;display:block;">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="field-label">Harga (Rp)</label>
                <input type="number" name="price" class="field-input"
                       value="{{ old('price', $produk->price) }}" required>
                @error('price')
                    <small style="color:#ef4444;font-size:12px;margin-top:6px;display:block;">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="field-label">Stok</label>
                <input type="number" name="stock" class="field-input"
                       value="{{ old('stock', $produk->stock) }}" required min="0">
                @error('stock')
                    <small style="color:#ef4444;font-size:12px;margin-top:6px;display:block;">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="field-label">Warna</label>
                <input type="text" name="color" class="field-input"
                       value="{{ old('color', $produk->color) }}"
                       placeholder="Contoh: Hitam, Coklat, Natural">
            </div>

            <div class="col-md-6">
                <label class="field-label">Bahan</label>
                <input type="text" name="material" class="field-input"
                       value="{{ old('material', $produk->material) }}"
                       placeholder="Contoh: Kulit Buaya Asli">
            </div>

            <div class="col-md-6">
                <label class="field-label">Ukuran</label>
                <input type="text" name="size" class="field-input"
                       value="{{ old('size', $produk->size) }}"
                       placeholder="Contoh: Panjang 23cm, Tinggi 20.5cm, Lebar 12.5cm">
            </div>

            <div class="col-md-6">
                <label class="field-label">Gambar Utama</label>
                @if($produk->main_image)
                    <div style="margin-bottom:12px;display:flex;align-items:center;gap:16px;">
                        <img src="{{ Storage::url($produk->main_image) }}" alt="Gambar saat ini" class="img-preview">
                        <div style="font-size:12px;color:#888;line-height:1.6;">
                            Gambar saat ini.<br>
                            Upload baru untuk mengganti.
                        </div>
                    </div>
                @endif
                <input type="file" name="main_image" class="field-input" accept="image/*">
                @error('main_image')
                    <small style="color:#ef4444;font-size:12px;margin-top:6px;display:block;">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-12">
                <label class="field-label">Foto Tambahan <span style="color:#888;font-weight:400;">(bisa pilih banyak — ditambahkan ke foto yang sudah ada)</span></label>
                @if($produk->images->isNotEmpty())
                    <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:12px;">
                        @foreach($produk->images as $img)
                            <div style="position:relative;">
                                <img src="{{ Storage::url($img->image_path) }}" style="width:70px;height:70px;object-fit:cover;border-radius:8px;border:1px solid #333;">
                                <form method="POST" action="{{ route('admin.produk.image.destroy', $img->id) }}"
                                      onsubmit="return confirm('Hapus foto ini?')"
                                      style="position:absolute;top:-6px;right:-6px;margin:0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background:#ef4444;color:#fff;border:none;border-radius:50%;width:20px;height:20px;display:flex;align-items:center;justify-content:center;font-size:11px;cursor:pointer;padding:0;">✕</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
                <input type="file" name="extra_images[]" class="field-input" accept="image/*" multiple>
                @error('extra_images.*')
                    <small style="color:#ef4444;font-size:12px;margin-top:6px;display:block;">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="field-label">No. WhatsApp CS</label>
                <input type="text" name="whatsapp_number" class="field-input"
                       value="{{ old('whatsapp_number', $produk->whatsapp_number) }}"
                       placeholder="Contoh: 6285891056675">
            </div>

            <div class="col-md-6">
                <label class="field-label">URL Shopee <span style="color:#888;font-weight:400;">(opsional)</span></label>
                <input type="url" name="shopee_url" class="field-input"
                       value="{{ old('shopee_url', $produk->shopee_url) }}"
                       placeholder="https://shopee.co.id/...">
            </div>

            <div class="col-md-6">
                <label class="field-label">URL TikTok Shop <span style="color:#888;font-weight:400;">(opsional)</span></label>
                <input type="url" name="tiktok_url" class="field-input"
                       value="{{ old('tiktok_url', $produk->tiktok_url) }}"
                       placeholder="https://www.tiktok.com/...">
            </div>

            <div class="col-md-6">
                <label class="field-label">Label Produk</label>
                <div style="display:flex;gap:1.5rem;margin-top:.5rem;flex-wrap:wrap">
                    <label style="display:flex;align-items:center;gap:.4rem;cursor:pointer;font-weight:500">
                        <input type="checkbox" name="is_new" value="1" {{ $produk->is_new ? 'checked' : '' }}> ✨ Produk Baru
                    </label>
                    <label style="display:flex;align-items:center;gap:.4rem;cursor:pointer;font-weight:500">
                        <input type="checkbox" name="is_promo" value="1" {{ $produk->is_promo ? 'checked' : '' }}> 🏷️ Promo
                    </label>
                    <label style="display:flex;align-items:center;gap:.4rem;cursor:pointer;font-weight:500">
                        <input type="checkbox" name="is_featured" value="1" {{ $produk->is_featured ? 'checked' : '' }}> 🔥 Terlaris
                    </label>
                </div>
            </div>

            {{-- Structured Description Editor --}}
            <div class="col-12">
                @php
                    $rawDescEdit = $produk->description ?? '';
                    $introEdit   = '';
                    $whyEdit     = [];
                    $detailEdit  = [];

                    if (preg_match('/✨\s*Why\s+You\'?ll\s+Love[\s\w]*✨(.*?)(?=Detail\s+Produk|$)/uis', $rawDescEdit, $wm)) {
                        $ip        = mb_substr($rawDescEdit, 0, mb_strpos($rawDescEdit, $wm[0]));
                        $introEdit = rtrim(trim(preg_replace('/\s+/', ' ', $ip)), " ✨");
                        $whyEdit   = array_values(array_filter(array_map('trim', preg_split('/✨/', trim($wm[1])))));
                    } elseif (mb_strpos($rawDescEdit, '•') !== false) {
                        $bp        = mb_strpos($rawDescEdit, '•');
                        $introEdit = rtrim(trim(mb_substr($rawDescEdit, 0, $bp)), " ✨");
                        preg_match_all('/•\s*(.+)/u', $rawDescEdit, $bm);
                        $whyEdit = array_map('trim', $bm[1] ?? []);
                    } else {
                        $introEdit = trim($rawDescEdit);
                    }

                    if (preg_match('/Detail\s+Produk\s*(.*?)(?=Produk dikirim|$)/uis', $rawDescEdit, $dm)) {
                        $lines      = array_filter(array_map('trim', preg_split('/\n/', trim($dm[1]))), fn($l) => mb_strlen($l) > 2);
                        if (count($lines) <= 1 && !empty($lines)) {
                            $lines = array_filter(array_map('trim', preg_split('/(?<=[a-z\)\.0-9])(?=[A-Z])/u', trim($dm[1]))), fn($l) => mb_strlen($l) > 2);
                        }
                        $detailEdit = array_values($lines);
                    }

                    if (empty($whyEdit))    $whyEdit    = [''];
                    if (empty($detailEdit)) $detailEdit = [''];
                @endphp

                <label class="field-label" style="margin-bottom:12px;">Deskripsi Produk</label>
                <div class="desc-section">

                    {{-- Intro --}}
                    <div class="desc-section-block">
                        <div class="desc-section-title">Deskripsi Utama</div>
                        <p class="desc-section-hint" style="margin-bottom:12px;">Ceritakan tentang produk — keunggulan, cocok untuk siapa, gaya, dll.</p>
                        <textarea name="intro" class="field-input" rows="4"
                                  placeholder="Contoh: Tas premium berbahan kulit buaya asli dari Merauke...">{{ old('intro', $introEdit) }}</textarea>
                    </div>

                    {{-- Why You'll Love It --}}
                    <div class="desc-section-block">
                        <div class="desc-section-header">
                            <div>
                                <div class="desc-section-title">✦ Why You'll Love It</div>
                                <p class="desc-section-hint">Poin keunggulan produk — ditampilkan sebagai highlight di halaman produk</p>
                            </div>
                            <button type="button" class="btn-desc-add" onclick="addItem('why-container','why_items[]','Contoh: Desain classy &amp; modern')">+ Tambah Poin</button>
                        </div>
                        <div id="why-container" class="desc-items">
                            @foreach($whyEdit as $i => $item)
                            <div class="desc-item">
                                <input type="text" name="why_items[]" class="field-input"
                                       value="{{ old("why_items.$i", $item) }}"
                                       placeholder="Contoh: Desain classy &amp; modern">
                                <button type="button" class="btn-desc-remove" onclick="removeItem(this)" title="Hapus">✕</button>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Detail Produk --}}
                    <div class="desc-section-block">
                        <div class="desc-section-header">
                            <div>
                                <div class="desc-section-title">Detail Produk</div>
                                <p class="desc-section-hint">Spesifikasi teknis — material, kompartemen, kelengkapan aksesoris, dll.</p>
                            </div>
                            <button type="button" class="btn-desc-add" onclick="addItem('detail-container','detail_items[]','Contoh: Material kulit premium kombinasi croco')">+ Tambah Detail</button>
                        </div>
                        <div id="detail-container" class="desc-items">
                            @foreach($detailEdit as $i => $item)
                            <div class="desc-item">
                                <input type="text" name="detail_items[]" class="field-input"
                                       value="{{ old("detail_items.$i", $item) }}"
                                       placeholder="Contoh: Material kulit premium kombinasi croco">
                                <button type="button" class="btn-desc-remove" onclick="removeItem(this)" title="Hapus">✕</button>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="form-divider">
            <button type="submit" class="btn-save">Simpan Perubahan →</button>
            <a href="{{ route('admin.produk.index') }}" class="btn-back">← Kembali ke Daftar</a>
        </div>
    </form>
</div>

@endsection

@section('scripts')
<script>
function addItem(containerId, name, placeholder) {
    const c = document.getElementById(containerId);
    const div = document.createElement('div');
    div.className = 'desc-item';
    div.innerHTML = `<input type="text" name="${name}" class="field-input" placeholder="${placeholder}"><button type="button" class="btn-desc-remove" onclick="removeItem(this)" title="Hapus">✕</button>`;
    c.appendChild(div);
    div.querySelector('input').focus();
}
function removeItem(btn) {
    const c = btn.closest('.desc-items');
    if (c.querySelectorAll('.desc-item').length > 1) btn.closest('.desc-item').remove();
}
</script>
@endsection
