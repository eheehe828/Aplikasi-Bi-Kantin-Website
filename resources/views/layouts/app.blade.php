<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Kantin Kita')</title>
    <style>
        :root {
            color-scheme: light;
            --ink: #192d27;
            --muted: #64736d;
            --paper: #f5f4ed;
            --panel: #fffefa;
            --green: #236b53;
            --green-dark: #184c3b;
            --lime: #d9ef8b;
            --coral: #ef745d;
            --line: #dce2d8;
            font-family: "Trebuchet MS", "Segoe UI", sans-serif;
        }

        * { box-sizing: border-box; }
        body {
            min-height: 100vh;
            margin: 0;
            color: var(--ink);
            background-color: var(--paper);
            background-image: radial-gradient(#cbd5c8 0.7px, transparent 0.7px);
            background-size: 18px 18px;
        }
        a { color: inherit; }
        .page { width: min(1080px, calc(100% - 36px)); margin: 0 auto; }
        .topbar { display: flex; align-items: center; justify-content: space-between; padding: 26px 0; }
        .brand { display: inline-flex; align-items: center; gap: 11px; text-decoration: none; font-weight: 800; }
        .brand-mark { display: grid; width: 38px; height: 38px; place-items: center; border-radius: 12px 12px 12px 4px; background: var(--green); color: white; font-family: Georgia, serif; font-size: 21px; }
        .brand-name { font-family: Georgia, serif; font-size: 20px; }
        .eyebrow { margin: 0 0 12px; color: var(--green); font-size: 11px; font-weight: 800; letter-spacing: 1.4px; text-transform: uppercase; }
        .login-grid { display: grid; grid-template-columns: 1.05fr 0.95fr; min-height: 600px; overflow: hidden; border: 1px solid var(--line); border-radius: 8px; background: var(--panel); box-shadow: 0 18px 55px #23352a12; }
        .intro { display: flex; flex-direction: column; justify-content: space-between; padding: clamp(32px, 6vw, 72px); background: var(--green); color: #f8f7ee; }
        .intro h1 { max-width: 470px; margin: 0; font-family: Georgia, serif; font-size: clamp(38px, 5vw, 60px); font-weight: 400; line-height: 1.03; }
        .intro .eyebrow { color: var(--lime); }
        .intro-note { max-width: 320px; margin: 24px 0 0; color: #d3e1d7; font-size: 15px; line-height: 1.7; }
        .stamp { align-self: flex-start; padding: 12px 16px; border: 1px solid #ffffff55; border-radius: 99px; color: var(--lime); font-size: 12px; font-weight: 700; }
        .form-side { display: flex; align-items: center; padding: clamp(28px, 5vw, 64px); }
        .form-wrap { width: 100%; max-width: 370px; margin: 0 auto; }
        .form-wrap h2 { margin: 0 0 8px; font-family: Georgia, serif; font-size: 34px; font-weight: 400; }
        .subcopy { margin: 0 0 32px; color: var(--muted); font-size: 14px; line-height: 1.6; }
        .field { display: block; margin: 0 0 19px; font-size: 13px; font-weight: 700; }
        .field input { display: block; width: 100%; min-height: 48px; margin-top: 8px; padding: 0 13px; border: 1px solid var(--line); border-radius: 4px; background: white; color: var(--ink); font: inherit; }
        .field input:focus { border-color: var(--green); outline: 3px solid #236b5324; }
        .error { margin: 7px 0 0; color: #a53d2f; font-size: 12px; font-weight: 500; }
        .button { display: inline-flex; min-height: 48px; align-items: center; justify-content: center; gap: 10px; padding: 0 18px; border: 0; border-radius: 4px; background: var(--green); color: white; cursor: pointer; font: inherit; font-weight: 700; text-decoration: none; }
        .button:hover { background: var(--green-dark); }
        .button-full { width: 100%; margin-top: 7px; }
        .dashboard { padding: 45px 0; }
        .dash-panel { padding: clamp(28px, 5vw, 56px); border: 1px solid var(--line); border-radius: 8px; background: var(--panel); }
        .dash-panel h1 { margin: 0; font-family: Georgia, serif; font-size: clamp(38px, 6vw, 58px); font-weight: 400; }
        .dash-panel p { color: var(--muted); line-height: 1.7; }
        .role-tag { display: inline-block; margin: 18px 0; padding: 7px 11px; border-radius: 99px; background: var(--lime); color: var(--green-dark); font-size: 11px; font-weight: 800; text-transform: uppercase; }
        .dash-actions { display: flex; align-items: center; gap: 12px; margin-top: 28px; }
        .logout-button { min-height: 44px; padding: 0 15px; border: 1px solid var(--line); border-radius: 4px; background: transparent; color: var(--ink); cursor: pointer; font: inherit; font-weight: 700; }
        .logout-button:hover { border-color: var(--coral); color: #a53d2f; }
        @media (max-width: 760px) {
            .page { width: min(100% - 24px, 520px); }
            .topbar { padding: 18px 0; }
            .login-grid { grid-template-columns: 1fr; }
            .intro { min-height: 280px; padding: 30px; }
            .intro h1 { font-size: 42px; }
            .intro-note { margin-top: 14px; font-size: 13px; }
            .stamp { margin-top: 24px; }
            .form-side { padding: 34px 24px 40px; }
            .dashboard { padding: 24px 0; }
        }
    </style>
</head>
<body>
    <div class="page">
        <header class="topbar">
            <a class="brand" href="{{ route('home') }}" aria-label="Kantin Kita, beranda">
                <span class="brand-mark" aria-hidden="true">K</span>
                <span class="brand-name">Kantin Kita</span>
            </a>
            @auth
                <span>{{ auth()->user()->name }}</span>
            @endauth
        </header>
        @yield('content')
    </div>
</body>
</html>