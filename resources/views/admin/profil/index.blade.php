@extends('admin.layout')
@section('title', 'Profil Admin')

@section('content')
@php $activeTab = session('tab', 'info'); @endphp

{{-- Header --}}
<div style="margin-bottom:1.25rem">
    <h1 style="font-size:1.3rem;font-weight:700;color:#1A3A2A;margin-bottom:.25rem">Profil Admin</h1>
    <p style="font-size:.85rem;color:#6b7280">Kelola akun, keamanan login, dan daftar admin</p>
</div>

{{-- Card info akun --}}
<div style="background:#fff;border-radius:14px;padding:1.25rem 1.5rem;box-shadow:0 1px 3px rgba(0,0,0,.07);display:flex;align-items:center;gap:1rem;margin-bottom:1.25rem">
    <div style="width:56px;height:56px;border-radius:50%;background:#1A3A2A;display:flex;align-items:center;justify-content:center;flex-shrink:0">
        <span style="font-size:1.4rem;font-weight:700;color:#C8A84B">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </span>
    </div>
    <div>
        <div style="font-size:1rem;font-weight:600;color:#1A3A2A">{{ Auth::user()->name }}</div>
        <div style="font-size:.82rem;color:#6b7280;margin-top:2px">{{ Auth::user()->email }}</div>
        <div style="font-size:.75rem;color:#C8A84B;margin-top:4px;font-weight:500">Administrator</div>
    </div>
</div>

{{-- Tab navigation --}}
<div style="display:flex;gap:.5rem;margin-bottom:1rem;border-bottom:1.5px solid #e5e7eb;padding-bottom:.5rem">
    @foreach([
        ['key' => 'info',     'label' => 'Info Akun',      'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
        ['key' => 'password', 'label' => 'Ubah Password',  'icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z'],
        ['key' => 'admin',    'label' => 'Kelola Admin',   'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0'],
    ] as $tab)
    <button onclick="switchTab('{{ $tab['key'] }}')"
            id="tab-{{ $tab['key'] }}"
            style="font-size:.85rem;font-weight:600;padding:.4rem 1rem;border-radius:8px;border:none;cursor:pointer;transition:all .15s;display:flex;align-items:center;gap:.4rem;
                   {{ $activeTab === $tab['key'] ? 'background:#1A3A2A;color:#fff' : 'background:transparent;color:#6b7280' }}">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $tab['icon'] }}"/>
        </svg>
        {{ $tab['label'] }}
    </button>
    @endforeach
</div>

{{-- Panel: Info Akun --}}
<div id="panel-info" style="{{ $activeTab !== 'info' ? 'display:none' : '' }}">
    @if(session('success_info'))
    <div style="background:#dcfce7;border:1px solid #86efac;border-radius:10px;padding:.75rem 1rem;display:flex;align-items:center;gap:.6rem;margin-bottom:1rem">
        <svg width="16" height="16" fill="none" stroke="#16a34a" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span style="font-size:.85rem;color:#166534">{{ session('success_info') }}</span>
    </div>
    @endif
    <div style="background:#fff;border-radius:14px;padding:1.5rem;box-shadow:0 1px 3px rgba(0,0,0,.07)">
        <form action="{{ route('admin.profil.update-info') }}" method="POST">
            @csrf
            @method('PUT')
            <div style="margin-bottom:1rem">
                <label style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:.4rem;text-transform:uppercase;letter-spacing:.05em">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}"
                       placeholder="Masukkan nama lengkap"
                       style="width:100%;border:1.5px solid {{ $errors->has('name') ? '#ef4444' : '#e5e7eb' }};border-radius:10px;padding:.65rem 1rem;font-size:.9rem;outline:none"
                       onfocus="this.style.borderColor='#1A3A2A'" onblur="this.style.borderColor='{{ $errors->has('name') ? '#ef4444' : '#e5e7eb' }}'">
                @error('name')<p style="color:#ef4444;font-size:.78rem;margin-top:.3rem">{{ $message }}</p>@enderror
            </div>
            <div style="margin-bottom:1.25rem">
                <label style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:.4rem;text-transform:uppercase;letter-spacing:.05em">Alamat Email Login</label>
                <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                       placeholder="Masukkan email aktif"
                       style="width:100%;border:1.5px solid {{ $errors->has('email') ? '#ef4444' : '#e5e7eb' }};border-radius:10px;padding:.65rem 1rem;font-size:.9rem;outline:none"
                       onfocus="this.style.borderColor='#1A3A2A'" onblur="this.style.borderColor='{{ $errors->has('email') ? '#ef4444' : '#e5e7eb' }}'">
                @error('email')<p style="color:#ef4444;font-size:.78rem;margin-top:.3rem">{{ $message }}</p>@enderror
                <p style="font-size:.78rem;color:#9ca3af;margin-top:.35rem">Email ini digunakan untuk login ke panel admin.</p>
            </div>
            <button type="submit"
                    style="background:#1A3A2A;color:#fff;font-size:.9rem;font-weight:600;padding:.65rem 1.5rem;border-radius:10px;border:none;cursor:pointer"
                    onmouseover="this.style.background='#0F2318'" onmouseout="this.style.background='#1A3A2A'">
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>

{{-- Panel: Ubah Password --}}
<div id="panel-password" style="{{ $activeTab !== 'password' ? 'display:none' : '' }}">
    @if(session('success_password'))
    <div style="background:#dcfce7;border:1px solid #86efac;border-radius:10px;padding:.75rem 1rem;display:flex;align-items:center;gap:.6rem;margin-bottom:1rem">
        <svg width="16" height="16" fill="none" stroke="#16a34a" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span style="font-size:.85rem;color:#166534">{{ session('success_password') }}</span>
    </div>
    @endif
    <div style="background:#fff;border-radius:14px;padding:1.5rem;box-shadow:0 1px 3px rgba(0,0,0,.07)">
        <form action="{{ route('admin.profil.update-password') }}" method="POST">
            @csrf
            @method('PUT')
            @foreach([
                ['id' => 'cur-pass',  'name' => 'current_password',      'label' => 'Password Lama',        'placeholder' => 'Masukkan password saat ini'],
                ['id' => 'new-pass',  'name' => 'password',               'label' => 'Password Baru',         'placeholder' => 'Minimal 8 karakter'],
                ['id' => 'conf-pass', 'name' => 'password_confirmation',  'label' => 'Konfirmasi Password',   'placeholder' => 'Ulangi password baru'],
            ] as $field)
            <div style="margin-bottom:1rem">
                <label style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:.4rem;text-transform:uppercase;letter-spacing:.05em">{{ $field['label'] }}</label>
                <div style="position:relative">
                    <input type="password" name="{{ $field['name'] }}" id="{{ $field['id'] }}" placeholder="{{ $field['placeholder'] }}"
                           style="width:100%;border:1.5px solid {{ $errors->has($field['name']) ? '#ef4444' : '#e5e7eb' }};border-radius:10px;padding:.65rem 2.8rem .65rem 1rem;font-size:.9rem;outline:none"
                           onfocus="this.style.borderColor='#1A3A2A'" onblur="this.style.borderColor='{{ $errors->has($field['name']) ? '#ef4444' : '#e5e7eb' }}'">
                    <button type="button" onclick="togglePass('{{ $field['id'] }}', this)"
                            style="position:absolute;right:.75rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;padding:0;color:#9ca3af;display:flex;align-items:center">
                        <svg class="eye-off" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18M10.6 10.6A3 3 0 0014 14M8.4 5.4A10.6 10.6 0 0112 5c6 0 9.5 7 9.5 7a18 18 0 01-3.1 4.1M6.1 6.1A18.4 18.4 0 002.5 12s3.5 7 9.5 7a10.8 10.8 0 004.8-1.1"/>
                        </svg>
                        <svg class="eye-on" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="display:none">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </button>
                </div>
                @error($field['name'])<p style="color:#ef4444;font-size:.78rem;margin-top:.3rem">{{ $message }}</p>@enderror
            </div>
            @endforeach
            <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:.75rem 1rem;margin-bottom:1.25rem;font-size:.8rem;color:#166534">
                <strong>Tips:</strong> Gunakan kombinasi huruf besar, kecil, angka, dan simbol agar password lebih kuat.
            </div>
            <button type="submit"
                    style="background:#1A3A2A;color:#fff;font-size:.9rem;font-weight:600;padding:.65rem 1.5rem;border-radius:10px;border:none;cursor:pointer"
                    onmouseover="this.style.background='#0F2318'" onmouseout="this.style.background='#1A3A2A'">
                Perbarui Password
            </button>
        </form>
    </div>
</div>

{{-- Panel: Kelola Admin --}}
<div id="panel-admin" style="{{ $activeTab !== 'admin' ? 'display:none' : '' }}">
    @if(session('success_admin'))
    <div style="background:#dcfce7;border:1px solid #86efac;border-radius:10px;padding:.75rem 1rem;display:flex;align-items:center;gap:.6rem;margin-bottom:1rem">
        <svg width="16" height="16" fill="none" stroke="#16a34a" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span style="font-size:.85rem;color:#166534">{{ session('success_admin') }}</span>
    </div>
    @endif
    <div style="background:#fff;border-radius:14px;padding:1.5rem;box-shadow:0 1px 3px rgba(0,0,0,.07);margin-bottom:1.25rem">
        <h3 style="font-size:.95rem;font-weight:700;color:#1A3A2A;margin-bottom:1rem">Tambah Admin Baru</h3>
        <form action="{{ route('admin.profil.store-admin') }}" method="POST">
            @csrf
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;margin-bottom:.75rem">
                <div>
                    <label style="display:block;font-size:.8rem;font-weight:600;color:#374151;margin-bottom:.35rem;text-transform:uppercase;letter-spacing:.05em">Nama</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama admin baru"
                           style="width:100%;border:1.5px solid #e5e7eb;border-radius:10px;padding:.6rem .9rem;font-size:.88rem;outline:none"
                           onfocus="this.style.borderColor='#1A3A2A'" onblur="this.style.borderColor='#e5e7eb'">
                    @error('name')<p style="color:#ef4444;font-size:.75rem;margin-top:.25rem">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label style="display:block;font-size:.8rem;font-weight:600;color:#374151;margin-bottom:.35rem;text-transform:uppercase;letter-spacing:.05em">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com"
                           style="width:100%;border:1.5px solid #e5e7eb;border-radius:10px;padding:.6rem .9rem;font-size:.88rem;outline:none"
                           onfocus="this.style.borderColor='#1A3A2A'" onblur="this.style.borderColor='#e5e7eb'">
                    @error('email')<p style="color:#ef4444;font-size:.75rem;margin-top:.25rem">{{ $message }}</p>@enderror
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;margin-bottom:1rem">
                <div>
                    <label style="display:block;font-size:.8rem;font-weight:600;color:#374151;margin-bottom:.35rem;text-transform:uppercase;letter-spacing:.05em">Password</label>
                    <div style="position:relative">
                        <input type="password" name="password" id="new-admin-pass" placeholder="Minimal 8 karakter"
                               style="width:100%;border:1.5px solid #e5e7eb;border-radius:10px;padding:.6rem 2.5rem .6rem .9rem;font-size:.88rem;outline:none"
                               onfocus="this.style.borderColor='#1A3A2A'" onblur="this.style.borderColor='#e5e7eb'">
                        <button type="button" onclick="togglePass('new-admin-pass', this)"
                                style="position:absolute;right:.65rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#9ca3af;padding:0;display:flex">
                            <svg class="eye-off" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18M10.6 10.6A3 3 0 0014 14M8.4 5.4A10.6 10.6 0 0112 5c6 0 9.5 7 9.5 7a18 18 0 01-3.1 4.1M6.1 6.1A18.4 18.4 0 002.5 12s3.5 7 9.5 7a10.8 10.8 0 004.8-1.1"/>
                            </svg>
                            <svg class="eye-on" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="display:none">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')<p style="color:#ef4444;font-size:.75rem;margin-top:.25rem">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label style="display:block;font-size:.8rem;font-weight:600;color:#374151;margin-bottom:.35rem;text-transform:uppercase;letter-spacing:.05em">Konfirmasi Password</label>
                    <div style="position:relative">
                        <input type="password" name="password_confirmation" id="conf-admin-pass" placeholder="Ulangi password"
                               style="width:100%;border:1.5px solid #e5e7eb;border-radius:10px;padding:.6rem 2.5rem .6rem .9rem;font-size:.88rem;outline:none"
                               onfocus="this.style.borderColor='#1A3A2A'" onblur="this.style.borderColor='#e5e7eb'">
                        <button type="button" onclick="togglePass('conf-admin-pass', this)"
                                style="position:absolute;right:.65rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#9ca3af;padding:0;display:flex">
                            <svg class="eye-off" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18M10.6 10.6A3 3 0 0014 14M8.4 5.4A10.6 10.6 0 0112 5c6 0 9.5 7 9.5 7a18 18 0 01-3.1 4.1M6.1 6.1A18.4 18.4 0 002.5 12s3.5 7 9.5 7a10.8 10.8 0 004.8-1.1"/>
                            </svg>
                            <svg class="eye-on" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="display:none">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <button type="submit"
                    style="background:#1A3A2A;color:#fff;font-size:.88rem;font-weight:600;padding:.6rem 1.4rem;border-radius:10px;border:none;cursor:pointer"
                    onmouseover="this.style.background='#0F2318'" onmouseout="this.style.background='#1A3A2A'">
                Tambah Admin
            </button>
        </form>
    </div>
    <div style="background:#fff;border-radius:14px;padding:1.5rem;box-shadow:0 1px 3px rgba(0,0,0,.07)">
        <h3 style="font-size:.95rem;font-weight:700;color:#1A3A2A;margin-bottom:1rem">Daftar Admin Lain</h3>
        @if($admins->isEmpty())
        <p style="font-size:.85rem;color:#9ca3af;text-align:center;padding:1rem 0">Belum ada admin lain.</p>
        @else
        <div style="display:flex;flex-direction:column;gap:.6rem">
            @foreach($admins as $admin)
            <div style="display:flex;align-items:center;justify-content:space-between;padding:.75rem 1rem;background:#f9fafb;border-radius:10px;border:0.5px solid #e5e7eb">
                <div style="display:flex;align-items:center;gap:.75rem">
                    <div style="width:36px;height:36px;border-radius:50%;background:#1A3A2A;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <span style="font-size:.9rem;font-weight:700;color:#C8A84B">{{ strtoupper(substr($admin->name, 0, 1)) }}</span>
                    </div>
                    <div>
                        <div style="font-size:.88rem;font-weight:600;color:#1A3A2A">{{ $admin->name }}</div>
                        <div style="font-size:.78rem;color:#6b7280">{{ $admin->email }}</div>
                    </div>
                </div>
                <form action="{{ route('admin.profil.destroy-admin', $admin) }}" method="POST"
                      onsubmit="return confirm('Hapus admin {{ $admin->name }}? Tindakan ini tidak bisa dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            style="background:#fee2e2;color:#dc2626;font-size:.78rem;font-weight:600;padding:.4rem .9rem;border-radius:8px;border:none;cursor:pointer"
                            onmouseover="this.style.background='#fecaca'" onmouseout="this.style.background='#fee2e2'">
                        Hapus
                    </button>
                </form>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

@endsection

@section('scripts')
<script>
function switchTab(tab) {
    ['info','password','admin'].forEach(t => {
        document.getElementById('panel-' + t).style.display = t === tab ? '' : 'none';
        const btn = document.getElementById('tab-' + t);
        btn.style.background = t === tab ? '#1A3A2A' : 'transparent';
        btn.style.color      = t === tab ? '#fff' : '#6b7280';
    });
}
function togglePass(inputId, btn) {
    const input  = document.getElementById(inputId);
    const isHide = input.type === 'password';
    input.type   = isHide ? 'text' : 'password';
    btn.querySelector('.eye-off').style.display = isHide ? 'none' : '';
    btn.querySelector('.eye-on').style.display  = isHide ? '' : 'none';
    btn.style.color = isHide ? '#1A3A2A' : '#9ca3af';
}
</script>
@endsection