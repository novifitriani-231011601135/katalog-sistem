<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — Siska Croco Jaya</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Montserrat', sans-serif;
            background:
                linear-gradient(rgba(4,14,8,0.82), rgba(4,14,8,0.82)),
                url('/images/kulit.jpg') center / cover fixed;
            overflow: hidden;
        }

        .bg-logo {
            position: fixed;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
            z-index: 0;
        }

        .bg-logo img {
            width: 60vmin;
            height: 60vmin;
            object-fit: contain;
            opacity: 0.04;
            filter: grayscale(100%) brightness(3);
        }

        .bg-overlay {
            position: fixed;
            inset: 0;
            background: radial-gradient(ellipse at center, rgba(10,40,20,0.5) 0%, rgba(2,8,4,0.6) 100%);
            z-index: 1;
        }

        .particles {
            position: fixed;
            inset: 0;
            z-index: 2;
            overflow: hidden;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            width: 2px;
            height: 2px;
            background: #c9a84c;
            border-radius: 50%;
            opacity: 0;
            animation: float linear infinite;
        }

        @keyframes float {
            0%   { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10%  { opacity: 0.6; }
            90%  { opacity: 0.3; }
            100% { transform: translateY(-10vh) rotate(720deg); opacity: 0; }
        }

        .wrapper {
            position: relative;
            z-index: 10;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .logo-circle {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            border: 3px solid rgba(201,168,76,0.5);
            box-shadow:
                0 0 0 10px rgba(201,168,76,0.08),
                0 0 0 20px rgba(26,83,46,0.12),
                0 0 60px rgba(201,168,76,0.25);
            overflow: hidden;
            background: #fff;
            margin-bottom: -90px;
            position: relative;
            z-index: 2;
        }

        .logo-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card {
            width: min(900px, 90vw);
            padding: 120px 100px 80px;
            background: linear-gradient(160deg, rgba(12,42,22,0.97) 0%, rgba(6,22,12,0.99) 100%);
            border: 1px solid rgba(201,168,76,0.25);
            box-shadow:
                0 0 0 1px rgba(26,83,46,0.3),
                0 60px 120px rgba(0,0,0,0.8),
                inset 0 1px 0 rgba(201,168,76,0.1);
            position: relative;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0; left: 6%; right: 6%;
            height: 2px;
            background: linear-gradient(to right, transparent, #c9a84c, #f0d080, #c9a84c, transparent);
        }

        .corner {
            position: absolute;
            width: 28px;
            height: 28px;
            border-color: rgba(201,168,76,0.4);
            border-style: solid;
        }
        .corner-tl { top: 18px; left: 18px;  border-width: 2px 0 0 2px; }
        .corner-tr { top: 18px; right: 18px; border-width: 2px 2px 0 0; }
        .corner-bl { bottom: 18px; left: 18px;  border-width: 0 0 2px 2px; }
        .corner-br { bottom: 18px; right: 18px; border-width: 0 2px 2px 0; }

        .brand-name {
            text-align: center;
            margin-bottom: 28px;
        }

        .brand-name h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 24px;
            font-weight: 400;
            color: rgba(201,168,76,0.7);
            letter-spacing: 8px;
            text-transform: uppercase;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 36px;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(201,168,76,0.3));
        }
        .divider::after { background: linear-gradient(to left, transparent, rgba(201,168,76,0.3)); }
        .divider span { color: #c9a84c; font-size: 20px; }

        .login-title {
            text-align: center;
            margin-bottom: 48px;
        }

        .login-title .sub {
            display: block;
            font-size: 16px;
            letter-spacing: 6px;
            text-transform: uppercase;
            color: rgba(52,199,89,0.9);
            margin-bottom: 16px;
        }

        .login-title h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 76px;
            font-weight: 300;
            color: #e8f5ee;
            letter-spacing: 2px;
            line-height: 1.05;
        }

        .error-box {
            background: rgba(180,60,60,0.1);
            border: 1px solid rgba(200,80,80,0.3);
            border-left: 4px solid #c84040;
            padding: 18px 22px;
            margin-bottom: 36px;
            color: #e09090;
            font-size: 18px;
            border-radius: 0 4px 4px 0;
        }

        .form-group {
            margin-bottom: 44px;
            position: relative;
        }

        .form-group label {
            display: block;
            font-size: 16px;
            letter-spacing: 5px;
            text-transform: uppercase;
            color: #4ade80;
            margin-bottom: 16px;
            opacity: 0.9;
        }

        .form-group input {
            width: 100%;
            background: transparent;
            border: none;
            border-bottom: 1px solid rgba(74,222,128,0.25);
            padding: 18px 0;
            color: #e8f5ee;
            font-family: 'Montserrat', sans-serif;
            font-size: 22px;
            font-weight: 300;
            letter-spacing: 1px;
            outline: none;
            transition: border-color 0.4s;
        }

        .form-group input:focus { border-bottom-color: rgba(74,222,128,0.7); }
        .form-group input::placeholder { color: rgba(232,245,238,0.18); }

        .form-group input[name="password"] {
            padding-right: 56px;
        }

        .toggle-password {
            position: absolute;
            right: 0;
            bottom: 4px;
            width: 44px;
            height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: transparent;
            border: 0;
            color: rgba(201,168,76,0.78);
            cursor: pointer;
            transform: none;
            transition: color 0.3s, transform 0.3s;
        }

        .toggle-password:hover,
        .toggle-password:focus-visible {
            color: #c9a84c;
            transform: scale(1.05);
            outline: none;
        }

        .toggle-password svg {
            width: 24px;
            height: 24px;
            pointer-events: none;
        }

        .toggle-password .icon-eye {
            display: none;
        }

        .toggle-password.is-visible .icon-eye {
            display: block;
        }

        .toggle-password.is-visible .icon-eye-off {
            display: none;
        }

        .form-group::after {
            content: '';
            position: absolute;
            bottom: 0; left: 50%;
            width: 0; height: 1px;
            background: linear-gradient(to right, #4ade80, #c9a84c);
            transition: all 0.4s;
            transform: translateX(-50%);
        }
        .form-group:focus-within::after { width: 100%; }

        .btn-login {
            width: 100%;
            padding: 26px;
            background: linear-gradient(135deg, #1a5c2e 0%, #0f3d1e 40%, #1a5c2e 100%);
            border: 1px solid rgba(201,168,76,0.45);
            color: #c9a84c;
            font-family: 'Montserrat', sans-serif;
            font-size: 18px;
            font-weight: 600;
            letter-spacing: 6px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.4s;
            margin-top: 16px;
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(201,168,76,0.15), transparent);
            transition: left 0.5s;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #c9a84c 0%, #a07830 100%);
            color: #0a1a10;
            border-color: #c9a84c;
            box-shadow: 0 12px 40px rgba(201,168,76,0.35);
            transform: translateY(-2px);
        }
        .btn-login:hover::before { left: 100%; }

        .footer-text {
            margin-top: 44px;
            text-align: center;
            font-size: 15px;
            letter-spacing: 3px;
            color: rgba(201,168,76,0.4);
            text-transform: uppercase;
        }
    </style>
</head>
<body>

<div class="bg-logo"><img src="{{ asset('images/logo.jpg') }}" alt=""></div>
<div class="bg-overlay"></div>
<div class="particles" id="particles"></div>

<div class="wrapper">
    <div class="logo-circle">
        <img src="{{ asset('images/logo.jpg') }}" alt="Logo Siska Croco Jaya">
    </div>

    <div class="card">
        <div class="corner corner-tl"></div>
        <div class="corner corner-tr"></div>
        <div class="corner corner-bl"></div>
        <div class="corner corner-br"></div>

        <div class="brand-name"><h1>Siska Croco Jaya</h1></div>
        <div class="divider"><span>✦</span></div>

        <div class="login-title">
            <span class="sub">Portal Admin</span>
            <h2>Selamat Datang</h2>
        </div>

        @if($errors->any())
        <div class="error-box">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="admin@siska.com" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="form-group">
                <label>Password</label>
                <button type="button" class="toggle-password" id="togglePassword" aria-label="Tampilkan password">
                    <svg class="icon-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                    <svg class="icon-eye-off" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M3 3l18 18"></path>
                        <path d="M10.6 10.6A3 3 0 0 0 14 14"></path>
                        <path d="M8.4 5.4A10.6 10.6 0 0 1 12 5c6 0 9.5 7 9.5 7a18 18 0 0 1-3.1 4.1"></path>
                        <path d="M6.1 6.1A18.4 18.4 0 0 0 2.5 12s3.5 7 9.5 7a10.8 10.8 0 0 0 4.8-1.1"></path>
                    </svg>
                </button>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn-login">Masuk →</button>
        </form>

        <div class="footer-text">© {{ date('Y') }} Siska Croco Jaya — All Rights Reserved</div>
    </div>
</div>

<script>
    const container = document.getElementById('particles');
    for (let i = 0; i < 25; i++) {
        const p = document.createElement('div');
        p.className = 'particle';
        p.style.left = Math.random() * 100 + 'vw';
        p.style.width = p.style.height = (Math.random() * 3 + 1) + 'px';
        p.style.animationDuration = (Math.random() * 15 + 10) + 's';
        p.style.animationDelay = (Math.random() * 10) + 's';
        container.appendChild(p);
    }

    const passwordInput = document.querySelector('input[name="password"]');
    const togglePassword = document.getElementById('togglePassword');

    togglePassword.addEventListener('click', () => {
        const isPasswordVisible = passwordInput.type === 'text';

        passwordInput.type = isPasswordVisible ? 'password' : 'text';
        togglePassword.classList.toggle('is-visible', !isPasswordVisible);
        togglePassword.setAttribute(
            'aria-label',
            isPasswordVisible ? 'Tampilkan password' : 'Sembunyikan password'
        );
    });
</script>
</body>
</html>
