@extends('admin.layout')

@section('title', 'Tambah Produk')

@section('content')

<div style="margin-bottom:48px;">
    <span class="page-label">Manajemen Produk</span>
    <h1 class="page-title">Tambah Produk</h1>
</div>

<div class="form-card">
    <form method="POST" action="{{ route('admin.produk.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row g-5">

            <div class="col-md-6">
                <label class="field-label">Nama Produk</label>
                <input type="text" name="name" class="field-input"
                       value="{{ old('name') }}" required
                       placeholder="Contoh: Dompet Kulit Buaya Premium">
                @error('name')
                    <small style="color:#ef4444;font-size:12px;margin-top:6px;display:block;">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="field-label">Kategori</label>
                <select name="category_id" class="field-input" required>
                    <option value="">— Pilih Kategori —</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
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
                <input type="text" name="price" id="price-input" class="field-input"
                       value="{{ old('price') }}" required
                       placeholder="Contoh: 1.900.000"
                       oninput="formatHarga(this)">
                @error('price')
                    <small style="color:#ef4444;font-size:12px;margin-top:6px;display:block;">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="field-label">Stok</label>
                <input type="number" name="stock" class="field-input"
                       value="{{ old('stock', 1) }}" required min="0"
                       style="text-align:center;"
                       onwheel="this.blur()">
                @error('stock')
                    <small style="color:#ef4444;font-size:12px;margin-top:6px;display:block;">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="field-label">Warna</label>
                <input type="text" name="color" class="field-input"
                       value="{{ old('color') }}"
                       placeholder="Contoh: Hitam, Coklat, Natural">
            </div>

            <div class="col-md-6">
                <label class="field-label">Bahan</label>
                <input type="text" name="material" class="field-input"
                       value="{{ old('material') }}"
                       placeholder="Contoh: Kulit Buaya Asli">
            </div>

            <div class="col-md-6">
                <label class="field-label">Ukuran</label>
                <input type="text" name="size" class="field-input"
                       value="{{ old('size') }}"
                       placeholder="Contoh: Panjang 23cm, Tinggi 20.5cm, Lebar 12.5cm">
            </div>

            <div class="col-md-6">
                <label class="field-label">Gambar Utama</label>
                <input type="file" name="main_image" class="field-input" accept="image/*">
                @error('main_image')
                    <small style="color:#ef4444;font-size:12px;margin-top:6px;display:block;">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="field-label">No. WhatsApp CS <span style="color:#888;font-weight:400;">(untuk tanya-tanya)</span></label>
                <input type="text" name="whatsapp_number" class="field-input"
                       value="{{ old('whatsapp_number', '6285891056675') }}"
                       placeholder="Contoh: 6285891056675">
            </div>

            <div class="col-md-6">
                <label class="field-label">URL Shopee <span style="color:#888;font-weight:400;">(opsional)</span></label>
                <input type="url" name="shopee_url" class="field-input"
                       value="{{ old('shopee_url') }}"
                       placeholder="https://shopee.co.id/...">
            </div>

            <div class="col-md-6">
                <label class="field-label">URL TikTok Shop <span style="color:#888;font-weight:400;">(opsional)</span></label>
                <input type="url" name="tiktok_url" class="field-input"
                       value="{{ old('tiktok_url') }}"
                       placeholder="https://www.tiktok.com/...">
            </div>

            <div class="col-md-6">
                <label class="field-label">Label Produk</label>
                <div style="display:flex;gap:1.5rem;margin-top:.5rem;flex-wrap:wrap">
                    <label style="display:flex;align-items:center;gap:.4rem;cursor:pointer;font-weight:500">
                        <input type="checkbox" name="is_new" value="1" {{ old('is_new') ? 'checked' : '' }}> ✨ Produk Baru
                    </label>
                    <label style="display:flex;align-items:center;gap:.4rem;cursor:pointer;font-weight:500">
                        <input type="checkbox" name="is_promo" value="1" {{ old('is_promo') ? 'checked' : '' }}> 🏷️ Promo
                    </label>
                    <label style="display:flex;align-items:center;gap:.4rem;cursor:pointer;font-weight:500">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}> 🔥 Terlaris
                    </label>
                </div>
            </div>

            {{-- Foto Tambahan dengan Drag & Drop --}}
            <div class="col-12">
                <label class="field-label">Foto Tambahan <span style="color:#888;font-weight:400;">(upload satu-satu, drag untuk atur urutan)</span></label>

                <div style="margin-bottom:12px">
                    <label for="foto-picker"
                           style="display:inline-flex;align-items:center;gap:8px;background:#1A3A2A;color:#fff;padding:10px 20px;border-radius:10px;cursor:pointer;font-size:14px;font-weight:600">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Tambah Foto
                    </label>
                    <input type="file" id="foto-picker" accept="image/*" multiple style="display:none" onchange="tambahFoto(this)">
                    <span style="font-size:12px;color:#9ca3af;margin-left:10px" id="foto-count">0 foto dipilih</span>
                </div>

                <div id="foto-preview-grid"
                     style="display:grid;grid-template-columns:repeat(auto-fill,minmax(120px,1fr));gap:10px;min-height:60px;padding:10px;background:#f9fafb;border:1.5px dashed #e5e7eb;border-radius:12px">
                    <div id="foto-empty-hint" style="grid-column:1/-1;text-align:center;color:#d1d5db;font-size:13px;padding:20px 0">
                        Belum ada foto. Klik "Tambah Foto" untuk upload.
                    </div>
                </div>

                <div id="foto-inputs"></div>

                <p style="font-size:12px;color:#9ca3af;margin-top:8px">
                    💡 Drag foto untuk atur urutan. Foto pertama = urutan pertama di halaman produk.
                </p>
            </div>

            <div class="col-12">
                <label class="field-label">Deskripsi Produk</label>
                <p style="font-size:13px;color:#888;margin-bottom:8px;">Tulis deskripsi lengkap produk, bisa paste langsung dari mana saja.</p>
                <textarea name="description" class="field-input" rows="10"
                          placeholder="Contoh:&#10;Tas premium berbahan kulit buaya asli...&#10;&#10;Keunggulan:&#10;- 100% kulit buaya asli&#10;- Desain classy dan modern&#10;&#10;Detail Produk:&#10;- Panjang 23cm, Tinggi 20cm&#10;- Warna: Hitam">{{ old('description') }}</textarea>
            </div>

        </div>

        <div class="form-divider">
            <button type="submit" class="btn-save">Simpan Produk →</button>
            <a href="{{ route('admin.produk.index') }}" class="btn-back">← Kembali ke Daftar</a>
        </div>
    </form>
</div>

@endsection

@section('scripts')
<script>
// ── Format harga ──────────────────────────────────────────────
function formatHarga(input) {
    let val = input.value.replace(/\D/g, '');
    input.value = val.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

document.querySelector('form').addEventListener('submit', function() {
    let harga = document.getElementById('price-input');
    harga.value = harga.value.replace(/\./g, '');
});

// ── Foto drag & drop ──────────────────────────────────────────
let fotoFiles = [];

function tambahFoto(input) {
    const files = Array.from(input.files);
    files.forEach(f => fotoFiles.push(f));
    input.value = '';
    renderFotoPreview();
}

function renderFotoPreview() {
    const grid   = document.getElementById('foto-preview-grid');
    const inputs = document.getElementById('foto-inputs');
    const count  = document.getElementById('foto-count');

    count.textContent = fotoFiles.length + ' foto dipilih';
    grid.innerHTML = '';
    inputs.innerHTML = '';

    if (fotoFiles.length === 0) {
        grid.innerHTML = `<div style="grid-column:1/-1;text-align:center;color:#d1d5db;font-size:13px;padding:20px 0">
            Belum ada foto. Klik "Tambah Foto" untuk upload.
        </div>`;
        return;
    }

    fotoFiles.forEach((file, idx) => {
        const card = document.createElement('div');
        card.draggable = true;
        card.dataset.idx = idx;
        card.style.cssText = 'position:relative;border-radius:10px;overflow:hidden;aspect-ratio:1;background:#f3f4f6;cursor:grab;border:2px solid transparent;transition:border-color .2s';

        const url = URL.createObjectURL(file);
        card.innerHTML = `
            <img src="${url}" style="width:100%;height:100%;object-fit:cover;">
            <div style="position:absolute;top:4px;left:4px;background:#1A3A2A;color:#C8A84B;font-size:10px;font-weight:700;width:20px;height:20px;border-radius:50%;display:flex;align-items:center;justify-content:center">${idx + 1}</div>
            <button type="button" onclick="hapusFoto(${idx})"
                    style="position:absolute;top:4px;right:4px;background:rgba(0,0,0,.55);color:#fff;border:none;width:20px;height:20px;border-radius:50%;cursor:pointer;font-size:11px;display:flex;align-items:center;justify-content:center;padding:0">✕</button>
        `;

        card.addEventListener('dragstart', e => {
            e.dataTransfer.setData('text/plain', idx);
            card.style.opacity = '0.4';
        });
        card.addEventListener('dragend', () => {
            card.style.opacity = '1';
        });
        card.addEventListener('dragover', e => {
            e.preventDefault();
            card.style.borderColor = '#1A3A2A';
        });
        card.addEventListener('dragleave', () => {
            card.style.borderColor = 'transparent';
        });
        card.addEventListener('drop', e => {
            e.preventDefault();
            card.style.borderColor = 'transparent';
            const fromIdx = parseInt(e.dataTransfer.getData('text/plain'));
            const toIdx   = parseInt(card.dataset.idx);
            if (fromIdx !== toIdx) {
                const moved = fotoFiles.splice(fromIdx, 1)[0];
                fotoFiles.splice(toIdx, 0, moved);
                renderFotoPreview();
            }
        });

        grid.appendChild(card);

        // Hidden input
        const dt = new DataTransfer();
        dt.items.add(file);
        const inp = document.createElement('input');
        inp.type = 'file';
        inp.name = 'extra_images[]';
        inp.style.display = 'none';
        inp.files = dt.files;
        inputs.appendChild(inp);
    });
}

function hapusFoto(idx) {
    fotoFiles.splice(idx, 1);
    renderFotoPreview();
}
</script>
@endsection