# Katalog Sistem - Modifikasi dari Siska Croco Jaya

## Stack
- **Laravel 12** (PHP 8.2+)
- **Blade Template** + Tailwind CSS
- **SQLite** (default) / bisa diganti MySQL

## 8 Fitur Sistem
1. Katalog Produk (filter kategori, search, filter Baru & Terlaris)
2. Detail Produk (multi-gambar, info lengkap, badge label)
3. Tombol Beli di Shopee & TikTok Shop + Tanya via WhatsApp (CS)
4. Halaman Profil Perusahaan
5. Ulasan / Testimoni Customer (form publik + admin approve)
6. Banner / Slider Promo di homepage (admin kelola)
7. Label Produk Baru & Terlaris (admin tandai, filter di katalog)
8. Admin Panel (CRUD produk, kategori, kelola ulasan, kelola banner, dashboard statistik)

---

## Cara Setup di Laptop

### 1. Install dependencies
```bash
composer install
```

### 2. Copy & setup .env
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Jalankan migration + seeder
```bash
php artisan migrate --seed
```

### 4. Buat symlink storage (untuk foto produk & banner)
```bash
php artisan storage:link
```

### 5. Jalankan server
```bash
php artisan serve
```

Buka: **http://localhost:8000**

---

## Login Admin
Setelah `migrate --seed`, akun admin default:
- **URL:** http://localhost:8000/admin/login
- **Email:** admin@siska.com
- **Password:** password

---

## Catatan
- Foto produk & banner disimpan di `storage/app/public/`
- Ulasan customer perlu **disetujui admin** sebelum tampil di halaman publik
- Tombol Shopee & TikTok muncul hanya jika URL-nya diisi di admin
- Filter Terlaris di katalog menggunakan flag `is_featured` yang bisa di-toggle di admin
