<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Siska Croco Jaya - Produk Kulit Buaya Premium')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style type="text/tailwindcss">
        @theme {
            --color-primary: #1A3A2A;
            --color-primary-dark: #0F2318;
            --color-primary-light: #2A5040;
            --color-accent: #C8A84B;
            --color-accent-dark: #A88A3A;
        }
        body { font-family: 'Inter', sans-serif; font-size: 18px; }
        .font-display { font-family: 'Playfair Display', serif; }

        #fav-drawer-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.45);
            z-index: 9999;
            display: none;
            justify-content: flex-end;
        }
        #fav-drawer-overlay.open { display: flex; }
        #fav-drawer {
            background: #fff;
            width: 340px;
            max-width: 92vw;
            height: 100%;
            display: flex;
            flex-direction: column;
            box-shadow: -8px 0 32px rgba(0,0,0,0.12);
        }
        .fav-item-card:hover { background: #F7F4EE; }
    </style>
    @yield('styles')
</head>
<body class="bg-[#FAF8F4] text-gray-800 min-h-screen flex flex-col">

    {{-- NAVBAR --}}
    <nav class="bg-[#1A3A2A] text-white sticky top-0 z-50 shadow-lg" x-data="{ open: false }">
        <div class="max-w-screen-2xl mx-auto px-6 sm:px-10 lg:px-16">
            <div class="flex items-center justify-between h-24">

                <a href="{{ route('home') }}" class="flex items-center gap-4 flex-shrink-0">
                    <img src="{{ asset('images/logobuaya.png') }}" alt="Logo" class="w-20 h-20 object-contain">
                    <div class="leading-none">
                        <div class="font-display font-bold text-[#C8A84B] text-3xl tracking-widest">SISKA</div>
                        <div class="text-sm tracking-[0.3em] text-gray-300 uppercase">Croco Jaya</div>
                    </div>
                </a>

                <div class="hidden md:flex items-center gap-10">
                    @php
                        $navLinks = [
                            ['route' => 'home',    'label' => 'Home'],
                            ['route' => 'katalog', 'label' => 'Katalog'],
                            ['route' => 'profile', 'label' => 'Profil'],
                        ];
                    @endphp
                    @foreach($navLinks as $link)
                        <a href="{{ route($link['route']) }}"
                           class="text-lg tracking-wide transition-colors font-medium
                                  {{ request()->routeIs($link['route']) ? 'text-[#C8A84B] border-b-2 border-[#C8A84B] pb-0.5' : 'text-gray-200 hover:text-[#C8A84B]' }}">
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                </div>

                <div class="hidden md:flex items-center gap-4">
                    <button onclick="openFavDrawer()"
                            class="relative flex items-center gap-2 text-gray-200 hover:text-[#C8A84B] transition-colors px-3 py-2 rounded-xl hover:bg-white/10"
                            aria-label="Lihat produk favorit">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span class="text-base font-medium">Favorit</span>
                        <span id="fav-nav-badge"
                              style="display:none; position:absolute; top:-6px; right:-6px; background:#C8A84B; color:#0F2318; font-size:11px; font-weight:700; width:20px; height:20px; border-radius:50%; align-items:center; justify-content:center;">
                            0
                        </span>
                    </button>
                </div>

                <button @click="open = !open" class="md:hidden p-2 text-gray-300 hover:text-white">
                    <svg x-show="!open" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="open" x-cloak class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <div x-show="open" x-transition x-cloak class="md:hidden border-t border-[#2A5040] bg-[#152E20] px-6 py-6 space-y-4">
            <a href="{{ route('home') }}" class="block text-base text-gray-200 hover:text-[#C8A84B] py-2">Home</a>
            <a href="{{ route('katalog') }}" class="block text-base text-gray-200 hover:text-[#C8A84B] py-2">Katalog</a>
            <a href="{{ route('profile') }}" class="block text-base text-gray-200 hover:text-[#C8A84B] py-2">Profil</a>
            <button onclick="openFavDrawer()"
                    class="flex items-center gap-2 text-gray-200 hover:text-[#C8A84B] py-2 text-base">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
                Favorit
                <span id="fav-nav-badge-mobile" style="display:none; background:#C8A84B; color:#0F2318; font-size:11px; font-weight:700; padding:1px 7px; border-radius:999px;">0</span>
            </button>
        </div>
    </nav>

    {{-- DRAWER FAVORIT --}}
    <div id="fav-drawer-overlay" onclick="closeFavDrawerOutside(event)">
        <div id="fav-drawer">
            <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100 bg-[#1A3A2A]">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-[#C8A84B]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    <span class="font-semibold text-white text-lg">Produk Favorit</span>
                    <span id="fav-drawer-count" class="bg-[#C8A84B] text-[#0F2318] text-xs font-bold px-2.5 py-0.5 rounded-full">0</span>
                </div>
                <button onclick="closeFavDrawer()" class="text-gray-300 hover:text-white transition-colors p-1" aria-label="Tutup">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div id="fav-drawer-list" class="flex-1 overflow-y-auto px-4 py-4 space-y-3"></div>

            <div id="fav-drawer-footer" class="px-6 py-4 border-t border-gray-100 bg-gray-50" style="display:none">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm text-gray-500">Total estimasi</span>
                    <span id="fav-drawer-total" class="font-bold text-gray-900 text-base">Rp 0</span>
                </div>
                
            </div>
        </div>
    </div>

    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="bg-[#1A3A2A] text-white mt-20">
        <div class="max-w-screen-2xl mx-auto px-6 py-14">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                @foreach([
                    ['icon' => 'M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z', 'text' => '100% Kulit Buaya Asli'],
                    ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'text' => 'Garansi Uang Kembali'],
                    ['icon' => 'M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z', 'text' => 'Pengiriman Seluruh Indonesia'],
                    ['icon' => 'M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z', 'text' => 'Layanan Pelanggan Responsif'],
                ] as $badge)
                    <div class="flex flex-col items-center gap-3">
                        <div class="w-16 h-16 rounded-full border-2 border-[#C8A84B] flex items-center justify-center">
                            <svg class="w-8 h-8 text-[#C8A84B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $badge['icon'] }}"/>
                            </svg>
                        </div>
                        <span class="text-base text-gray-300 font-medium">{{ $badge['text'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="border-t border-[#2A5040] text-center text-sm text-gray-400 py-6">
            © {{ date('Y') }} Siska Croco Jaya. Semua hak dilindungi.
        </div>
    </footer>

    <script>
    function getFavs() {
        try { return JSON.parse(localStorage.getItem('siska_favs') || '[]'); }
        catch { return []; }
    }
    function saveFavs(favs) {
        localStorage.setItem('siska_favs', JSON.stringify(favs));
    }
    function isFav(id) {
        return getFavs().some(f => String(f.id) === String(id));
    }
    function toggleFav(id, name, price, img, url) {
        let favs = getFavs();
        const idx = favs.findIndex(f => String(f.id) === String(id));
        if (idx === -1) {
            favs.push({ id: String(id), name, price, img, url });
            saveFavs(favs);
            showFavToast('Disimpan ke favorit!');
        } else {
            favs.splice(idx, 1);
            saveFavs(favs);
            showFavToast('Dihapus dari favorit');
        }
        updateAllFavButtons(id);
        updateFavBadge();
        renderFavDrawerList();
    }
    function updateAllFavButtons(id) {
        const active = isFav(id);
        document.querySelectorAll('[data-fav-id="' + id + '"]').forEach(btn => {
            const svg = btn.querySelector('svg');
            if (!svg) return;
            if (active) {
                svg.setAttribute('fill', '#1A3A2A');
                svg.setAttribute('stroke', '#1A3A2A');
            } else {
                svg.setAttribute('fill', 'none');
                svg.setAttribute('stroke', 'currentColor');
            }
        });
    }
    function updateFavBadge() {
        const n = getFavs().length;
        ['fav-nav-badge', 'fav-nav-badge-mobile'].forEach(id => {
            const el = document.getElementById(id);
            if (!el) return;
            el.textContent = n;
            el.style.display = n > 0 ? 'inline-flex' : 'none';
        });
        const dc = document.getElementById('fav-drawer-count');
        if (dc) dc.textContent = n;
    }
    function renderFavDrawerList() {
        const favs   = getFavs();
        const list   = document.getElementById('fav-drawer-list');
        const footer = document.getElementById('fav-drawer-footer');
        if (!list) return;
        if (favs.length === 0) {
            list.innerHTML = `
                <div class="flex flex-col items-center justify-center py-16 text-center">
                    <svg class="w-14 h-14 text-gray-200 mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    <p class="text-gray-400 text-sm font-medium">Belum ada produk favorit</p>
                    <p class="text-gray-300 text-xs mt-1">Klik ❤ di foto produk untuk menyimpan</p>
                </div>`;
            if (footer) footer.style.display = 'none';
            return;
        }
        let total = 0;
        list.innerHTML = favs.map(f => {
            const rawPrice = parseInt(f.price.replace(/[^0-9]/g, '')) || 0;
            total += rawPrice;
            return `
            <a href="${f.url}"
               class="fav-item-card flex items-center gap-3 p-3 rounded-xl border border-gray-100 cursor-pointer transition-colors no-underline">
                <img src="${f.img}" alt="${f.name}"
                     class="w-16 h-16 object-cover rounded-xl flex-shrink-0 border border-gray-100"
                     onerror="this.src='https://via.placeholder.com/64x64?text=Produk'">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-800 line-clamp-2 leading-snug">${f.name}</p>
                    <p class="text-sm font-bold text-gray-900 mt-1">${f.price}</p>
                </div>
                <button onclick="event.preventDefault(); event.stopPropagation(); toggleFav('${f.id}','${f.name}','${f.price}','${f.img}','${f.url}')"
                        class="flex-shrink-0 p-1.5 text-gray-300 hover:text-red-400 transition-colors rounded-lg hover:bg-red-50"
                        aria-label="Hapus dari favorit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </a>`;
        }).join('');
        if (footer) {
            footer.style.display = 'block';
            const totalEl = document.getElementById('fav-drawer-total');
            if (totalEl) totalEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
        }
    }
    function openFavDrawer() {
        renderFavDrawerList();
        document.getElementById('fav-drawer-overlay').classList.add('open');
        document.body.style.overflow = 'hidden';
    }
    function closeFavDrawer() {
        document.getElementById('fav-drawer-overlay').classList.remove('open');
        document.body.style.overflow = '';
    }
    function closeFavDrawerOutside(e) {
        if (e.target === document.getElementById('fav-drawer-overlay')) closeFavDrawer();
    }
    function showFavToast(msg) {
        let toast = document.getElementById('fav-toast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'fav-toast';
            toast.style.cssText = 'position:fixed;bottom:24px;left:50%;transform:translateX(-50%);background:#1A3A2A;color:#fff;font-size:13px;font-weight:500;padding:10px 20px;border-radius:999px;z-index:99999;opacity:0;transition:opacity .3s;pointer-events:none;white-space:nowrap;';
            document.body.appendChild(toast);
        }
        toast.textContent = msg;
        toast.style.opacity = '1';
        clearTimeout(window._favToastTimer);
        window._favToastTimer = setTimeout(() => { toast.style.opacity = '0'; }, 2200);
    }
    document.addEventListener('DOMContentLoaded', () => {
        updateFavBadge();
        document.querySelectorAll('[data-fav-id]').forEach(btn => {
            const id = btn.dataset.favId;
            if (isFav(id)) {
                const svg = btn.querySelector('svg');
                if (svg) {
                    svg.setAttribute('fill', '#1A3A2A');
                    svg.setAttribute('stroke', '#1A3A2A');
                }
            }
        });
    });
    </script>

    @yield('scripts')
</body>
</html>