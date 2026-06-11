<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Siska Croco Jaya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%;
            font-family: 'Montserrat', sans-serif;
            font-size: 15px;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Layout ── */
        .admin-wrap {
            display: flex;
            min-height: 100vh;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: 290px;
            flex-shrink: 0;
            background: linear-gradient(180deg, #040d08 0%, #071410 100%);
            border-right: 1px solid rgba(201,168,76,0.14);
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 36px 24px 28px;
            border-bottom: 1px solid rgba(201,168,76,0.1);
            text-align: center;
        }

        .sidebar-brand img {
            width: 88px;
            height: 88px;
            border-radius: 50%;
            border: 1.5px solid rgba(201,168,76,0.4);
            object-fit: cover;
            box-shadow: 0 0 0 5px rgba(201,168,76,0.07), 0 8px 28px rgba(0,0,0,0.5);
        }

        .sidebar-brand-name {
            display: block;
            font-family: 'Cormorant Garamond', serif;
            font-size: 20px;
            font-weight: 500;
            letter-spacing: 3px;
            color: rgba(201,168,76,0.85);
            text-transform: uppercase;
            margin-top: 14px;
        }

        .sidebar-brand-sub {
            display: block;
            font-size: 10px;
            letter-spacing: 2.5px;
            color: rgba(255,255,255,0.28);
            text-transform: uppercase;
            margin-top: 5px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 16px 0;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 13px;
            color: rgba(255,255,255,0.5);
            font-size: 14px;
            font-weight: 500;
            letter-spacing: 0.4px;
            padding: 17px 28px;
            border-left: 3px solid transparent;
            text-decoration: none;
            transition: color 0.22s, border-color 0.22s, background 0.22s;
            position: relative;
        }

        .sidebar-nav a svg {
            flex-shrink: 0;
            opacity: 0.6;
            transition: opacity 0.22s;
        }

        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            color: #c9a84c;
            border-left-color: #c9a84c;
            background: rgba(201,168,76,0.07);
        }

        .sidebar-nav a:hover svg,
        .sidebar-nav a.active svg {
            opacity: 1;
        }

        .sidebar-footer {
            padding: 20px 22px;
            border-top: 1px solid rgba(201,168,76,0.1);
        }

        .btn-logout {
            width: 100%;
            background: transparent;
            border: 1px solid rgba(201,168,76,0.2);
            color: rgba(201,168,76,0.5);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 13px 20px;
            cursor: pointer;
            transition: all 0.22s;
            font-family: 'Montserrat', sans-serif;
            border-radius: 8px;
        }

        .btn-logout:hover {
            color: #c9a84c;
            border-color: rgba(201,168,76,0.5);
            background: rgba(201,168,76,0.06);
        }

        /* ── Main content ── */
        .main-content {
            flex: 1;
            min-width: 0;
            background:
                linear-gradient(rgba(4,14,8,0.89), rgba(4,14,8,0.89)),
                url('/images/kulit.jpg') center / cover fixed;
            padding: 56px 72px 80px;
            min-height: 100vh;
        }

        .content-inner {
            max-width: 1440px;
        }

        /* ── Page header ── */
        .page-label {
            display: block;
            font-size: 11px;
            letter-spacing: 3.5px;
            text-transform: uppercase;
            color: rgba(201,168,76,0.65);
            margin-bottom: 8px;
            font-weight: 700;
        }

        .page-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 72px;
            font-weight: 300;
            color: #eaf4ee;
            line-height: 1.0;
        }

        /* ── Alert ── */
        .alert-ok {
            background: rgba(74,222,128,0.08);
            border-left: 3px solid #4ade80;
            color: #86efac;
            font-size: 14px;
            font-weight: 500;
            padding: 16px 20px;
            margin-bottom: 28px;
            border-radius: 0 8px 8px 0;
        }

        /* ── Buttons ── */
        .btn-add {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(201,168,76,0.1);
            color: #c9a84c;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            padding: 15px 32px;
            border-radius: 10px;
            text-decoration: none;
            border: 1px solid rgba(201,168,76,0.32);
            transition: all 0.25s;
            cursor: pointer;
            font-family: 'Montserrat', sans-serif;
            white-space: nowrap;
        }

        .btn-add:hover {
            background: #c9a84c;
            color: #0a1a10;
            border-color: #c9a84c;
            box-shadow: 0 6px 24px rgba(201,168,76,0.28);
            transform: translateY(-1px);
        }

        .btn-edit {
            display: inline-flex;
            align-items: center;
            border: 1px solid rgba(201,168,76,0.32);
            background: rgba(201,168,76,0.07);
            color: #c9a84c;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            padding: 9px 20px;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.2s;
            white-space: nowrap;
            font-family: 'Montserrat', sans-serif;
        }

        .btn-edit:hover {
            background: #c9a84c;
            color: #0a1a10;
            border-color: #c9a84c;
        }

        .btn-del {
            display: inline-flex;
            align-items: center;
            border: 1px solid rgba(220,80,80,0.3);
            background: rgba(220,80,80,0.06);
            color: #f87171;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            padding: 9px 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'Montserrat', sans-serif;
            white-space: nowrap;
        }

        .btn-del:hover {
            background: #ef4444;
            color: #fff;
            border-color: #ef4444;
        }

        .btn-save {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: #c9a84c;
            border: none;
            color: #0a1a10;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            padding: 17px 48px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.25s;
            font-family: 'Montserrat', sans-serif;
            box-shadow: 0 4px 18px rgba(201,168,76,0.22);
        }

        .btn-save:hover {
            background: #d4b460;
            box-shadow: 0 8px 30px rgba(201,168,76,0.42);
            transform: translateY(-1px);
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 500;
            color: rgba(255,255,255,0.38);
            text-decoration: none;
            letter-spacing: 0.3px;
            transition: color 0.2s;
        }

        .btn-back:hover { color: rgba(255,255,255,0.75); }

        /* ── Table card ── */
        .table-card {
            background: rgba(255,255,255,0.98);
            border: 1px solid rgba(232,224,208,0.7);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 48px rgba(0,0,0,0.28);
        }

        .table-card table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-card thead th {
            padding: 18px 28px;
            background: #0a1a10;
            color: rgba(201,168,76,0.8);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.8px;
            text-transform: uppercase;
            text-align: left;
            white-space: nowrap;
        }

        .table-card tbody td {
            padding: 20px 28px;
            font-size: 14px;
            color: #1a1a1a;
            border-bottom: 1px solid #f2ede6;
            vertical-align: middle;
        }

        .table-card tbody tr:last-child td { border-bottom: none; }

        .table-card tbody tr {
            transition: background-color 0.18s;
        }

        .table-card tbody tr:hover td {
            background: #fdf9ef;
        }

        /* ── Form card ── */
        .form-card {
            background: rgba(255,255,255,0.98);
            border: 1px solid rgba(232,224,208,0.6);
            border-top: 4px solid #c9a84c;
            border-radius: 16px;
            padding: 56px 64px;
            box-shadow: 0 8px 48px rgba(0,0,0,0.22);
        }

        .field-label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.8px;
            text-transform: uppercase;
            color: rgba(201,168,76,0.85);
            margin-bottom: 10px;
        }

        .field-input {
            width: 100%;
            border: 1.5px solid #e8e2d8;
            border-radius: 10px;
            padding: 15px 18px;
            font-size: 15px;
            background: #faf8f5;
            color: #111;
            font-family: 'Montserrat', sans-serif;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }

        .field-input:focus {
            border-color: #c9a84c;
            box-shadow: 0 0 0 3px rgba(201,168,76,0.12);
            background: #fff;
            outline: none;
        }

        /* ── Form divider ── */
        .form-divider {
            margin-top: 40px;
            padding-top: 32px;
            border-top: 1px solid #f0ece4;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        /* ── Dashboard action cards ── */
        .action-card {
            display: block;
            padding: 48px 52px 44px;
            background: rgba(8, 22, 13, 0.72);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid rgba(201,168,76,0.16);
            border-radius: 18px;
            text-decoration: none;
            transition: border-color 0.3s, transform 0.3s, box-shadow 0.3s;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .action-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(201,168,76,0.35), transparent);
        }

        .action-card:hover {
            border-color: rgba(201,168,76,0.42);
            transform: translateY(-5px);
            box-shadow: 0 24px 72px rgba(0,0,0,0.4), 0 0 0 1px rgba(201,168,76,0.1);
        }

        .action-num {
            font-family: 'Cormorant Garamond', serif;
            font-size: 100px;
            font-weight: 300;
            color: rgba(201,168,76,0.1);
            line-height: 1;
            margin-bottom: 20px;
        }

        .action-title {
            font-size: 16px;
            font-weight: 700;
            color: #c9a84c;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 2.5px;
        }

        .action-desc {
            font-size: 13px;
            color: rgba(235,228,210,0.45);
            font-weight: 400;
            line-height: 1.65;
        }

        .action-arrow {
            position: absolute;
            bottom: 28px;
            right: 32px;
            color: rgba(201,168,76,0.25);
            transition: color 0.25s, transform 0.25s;
            font-size: 18px;
        }

        .action-card:hover .action-arrow {
            color: rgba(201,168,76,0.65);
            transform: translate(3px, -3px);
        }

        /* ── Description editor ── */
        .desc-section {
            border: 1.5px solid #e8e2d8;
            border-radius: 12px;
            overflow: hidden;
            background: #faf8f5;
        }

        .desc-section-block {
            padding: 24px 28px;
            border-bottom: 1px solid #f0ece4;
        }

        .desc-section-block:last-child { border-bottom: none; }

        .desc-section-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 14px;
        }

        .desc-section-title { font-size: 11px; font-weight: 700; letter-spacing: 1.8px; text-transform: uppercase; color: rgba(201,168,76,0.85); margin-bottom: 3px; }
        .desc-section-hint { font-size: 12px; color: #aaa; margin: 0; }

        .desc-items { display: flex; flex-direction: column; gap: 10px; }

        .desc-item { display: flex; align-items: center; gap: 10px; }
        .desc-item .field-input { flex: 1; margin: 0; }

        .btn-desc-add {
            background: rgba(201,168,76,0.1);
            border: 1px solid rgba(201,168,76,0.3);
            color: #c9a84c;
            font-size: 11px;
            font-weight: 700;
            padding: 9px 18px;
            border-radius: 8px;
            cursor: pointer;
            letter-spacing: 0.8px;
            white-space: nowrap;
            transition: all 0.2s;
            font-family: 'Montserrat', sans-serif;
            flex-shrink: 0;
        }

        .btn-desc-add:hover { background: #c9a84c; color: #0a1a10; }

        .btn-desc-remove {
            background: rgba(239,68,68,0.08);
            border: 1px solid rgba(239,68,68,0.2);
            color: #f87171;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            flex-shrink: 0;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-desc-remove:hover { background: #ef4444; color: #fff; border-color: #ef4444; }

        /* ── Image preview ── */
        .img-preview {
            width: 110px;
            height: 110px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid rgba(201,168,76,0.25);
        }

        /* ── Table thumbnail ── */
        .table-thumb {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #ece6db;
            display: block;
        }

        .table-thumb-placeholder {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            background: #f5f0e8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            border: 1px solid #ece6db;
        }

        /* ── Badges ── */
        .badge-cat {
            display: inline-block;
            background: rgba(10,26,16,0.08);
            color: #1a3a1a;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 20px;
            white-space: nowrap;
            letter-spacing: 0.3px;
        }

        .badge-stock-ok {
            display: inline-block;
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            background: rgba(74,222,128,0.1);
            color: #15803d;
        }

        .badge-stock-empty {
            display: inline-block;
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            background: rgba(200,64,64,0.1);
            color: #c84040;
        }

        .badge-count {
            display: inline-block;
            background: rgba(10,26,16,0.08);
            color: #0a1a10;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 14px;
            border-radius: 20px;
        }
    </style>
    @yield('head')
</head>
<body>
<div class="admin-wrap">

    {{-- Sidebar --}}
    <aside class="sidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('images/logo.jpg') }}" alt="Logo">
            <span class="sidebar-brand-name">Siska Croco</span>
            <span class="sidebar-brand-sub">Admin Panel</span>
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}"
               class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                    <rect x="3" y="3" width="7" height="7" rx="1.5"/>
                    <rect x="14" y="3" width="7" height="7" rx="1.5"/>
                    <rect x="3" y="14" width="7" height="7" rx="1.5"/>
                    <rect x="14" y="14" width="7" height="7" rx="1.5"/>
                </svg>
                Dashboard
            </a>
            <a href="{{ route('admin.produk.index') }}"
               class="{{ request()->routeIs('admin.produk.*') ? 'active' : '' }}">
                <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                Produk
            </a>
            <a href="{{ route('admin.kategori.index') }}"
               class="{{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                Kategori
            </a>
            <a href="{{ route('admin.ulasan.index') }}"
               class="{{ request()->routeIs('admin.ulasan.*') ? 'active' : '' }}">
                <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
                Ulasan
            </a>
            <a href="{{ route('admin.banner.index') }}"
               class="{{ request()->routeIs('admin.banner.*') ? 'active' : '' }}">
                <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Banner
            </a>
            <a href="{{ route('admin.profil.index') }}"
   style="display:flex;align-items:center;gap:.6rem;padding:.6rem .8rem;border-radius:8px;text-decoration:none;font-size:.88rem;font-weight:500;
          {{ request()->routeIs('admin.profil.*') ? 'background:#1A3A2A;color:#fff' : 'color:#374151' }}"
   onmouseover="if(!{{ request()->routeIs('admin.profil.*') ? 'true' : 'false' }}) this.style.background='#f3f4f6'"
   onmouseout="if(!{{ request()->routeIs('admin.profil.*') ? 'true' : 'false' }}) this.style.background='transparent'">
    <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
    </svg>
    Profil Admin
</a>
        </nav>
        <div class="sidebar-footer">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button class="btn-logout">Logout</button>
            </form>
        </div>
    </aside>

    {{-- Main content --}}
    <main class="main-content">
        <div class="content-inner">
            @yield('content')
        </div>
    </main>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
