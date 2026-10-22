<!DOCTYPE html>
<html lang="id" class="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Indo Consulting - Bergerak Bertumbuh Bersama')</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <meta name="description" content="@yield('description', 'Indo Consulting adalah lembaga konsultan terkemuka bidang Manajemen Pendidikan, Pengembangan SDM, Keuangan dan Pajak, Teknologi Informasi, Hukum dan Perizinan.')">

    {{-- Open Graph / Social Sharing --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Indo Consulting">
    <meta property="og:title" content="@yield('title', 'Indo Consulting - Bergerak Bertumbuh Bersama')">
    <meta property="og:description" content="@yield('description', 'Indo Consulting adalah lembaga konsultan terkemuka bidang Manajemen Pendidikan, Pengembangan SDM, Keuangan dan Pajak, Teknologi Informasi, Hukum dan Perizinan.')">
    <meta property="og:image" content="@yield('og_image', asset('favicon.ico'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <link rel="sitemap" type="application/xml" href="{{ route('sitemap') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Indo Consulting')">
    <meta name="twitter:description" content="@yield('description', '')">
    <meta name="twitter:image" content="@yield('og_image', asset('favicon.ico'))">

    {{-- Tailwind CSS via Vite (production build) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <style>
        [x-cloak] { display: none !important; }
        
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .icon-filled {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        /* Responsive padding override */
        .px-responsive {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
        @media (min-width: 1024px) {
            .px-responsive {
                padding-left: 2rem;
                padding-right: 2rem;
            }
        }
        @media (min-width: 1280px) {
            .px-responsive {
                padding-left: 3rem;
                padding-right: 3rem;
            }
        }

        /* Hero pattern background with noise texture */
        .hero-pattern {
            background-color: #020220;
            background-image:
                radial-gradient(circle at 80% 20%, rgba(187, 0, 39, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 20% 80%, rgba(26, 27, 58, 0.8) 0%, transparent 50%);
            position: relative;
        }
        .hero-pattern::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="300" height="300"><filter id="n"><feTurbulence baseFrequency="0.9" numOctaves="3"/></filter><rect width="300" height="300" filter="url(%23n)" opacity="0.05"/></svg>');
            pointer-events: none;
            mix-blend-mode: overlay;
            z-index: 1;
        }

        /* Premium Shadows - Navy-tinted (high-end-visual-design) */
        .soft-shadow {
            box-shadow: 0 1px 3px 0 rgba(2, 2, 32, 0.08), 0 1px 2px -1px rgba(2, 2, 32, 0.06);
            transition: all 700ms cubic-bezier(0.32, 0.72, 0, 1);
        }
        .soft-shadow-md {
            box-shadow: 0 4px 6px -1px rgba(2, 2, 32, 0.08), 0 2px 4px -2px rgba(2, 2, 32, 0.06);
            transition: all 700ms cubic-bezier(0.32, 0.72, 0, 1);
        }
        .shadow-lifted {
            box-shadow: 0 10px 15px -3px rgba(2, 2, 32, 0.08), 0 4px 6px -4px rgba(2, 2, 32, 0.06);
            transition: all 700ms cubic-bezier(0.32, 0.72, 0, 1);
        }

        /* Dropdown animation */
        .dropdown-menu {
            transform: translateY(-8px);
            opacity: 0;
            pointer-events: none;
            transition: transform 0.2s ease, opacity 0.2s ease;
        }
        .dropdown-trigger:hover .dropdown-menu,
        .dropdown-trigger:focus-within .dropdown-menu {
            transform: translateY(0);
            opacity: 1;
            pointer-events: auto;
        }

        /* Mobile menu slide */
        #mobile-menu {
            transition: max-height 0.35s ease, opacity 0.3s ease;
            max-height: 0;
            opacity: 0;
            overflow: hidden;
        }
        #mobile-menu.open {
            max-height: calc(100vh - 4rem);
            opacity: 1;
            overflow-y: auto;
        }

        /* Card hover lift with premium spring physics */
        .card-hover {
            transition: transform 700ms cubic-bezier(0.32, 0.72, 0, 1),
                        box-shadow 700ms cubic-bezier(0.32, 0.72, 0, 1);
        }
        .card-hover:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 48px rgba(2, 2, 32, 0.12);
        }
        .card-hover:active {
            transform: translateY(-2px) scale(0.99);
            transition: transform 150ms cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        /* Scroll reveal */
        .reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.65s cubic-bezier(0.16, 1, 0.3, 1), transform 0.65s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Page hero divider wave */
        .wave-divider {
            background: #fbf9f8;
            clip-path: ellipse(100% 55% at 50% 100%);
        }

        /* Active nav indicator - premium pill style */
        .nav-active {
            color: #020220;
            background-color: #e2e8f0;
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem;
            font-weight: 600;
        }

        /* Marquee for partners */
        @keyframes marquee {
            0%   { transform: translate3d(0, 0, 0); }
            100% { transform: translate3d(-100%, 0, 0); }
        }
        .marquee-wrap {
            display: flex;
            width: max-content;
            user-select: none;
        }
        .marquee-set {
            display: flex;
            align-items: center;
            gap: 3rem;
            padding-right: 3rem;
            animation: marquee 35s linear infinite;
            flex-shrink: 0;
            will-change: transform;
        }
        .marquee-wrap:hover .marquee-set {
            animation-play-state: paused;
        }

        /* Button press effect - Apple style (fully rounded) */
        .btn-primary {
            background: #bb0027;
            color: #ffffff;
            border-radius: 980px;
            transition: all 700ms cubic-bezier(0.32, 0.72, 0, 1);
        }
        .btn-primary:hover  { background: #9a001f; transform: scale(1.02); }
        .btn-primary:active { transform: scale(0.98); }

        .btn-secondary {
            background: transparent;
            color: #020220;
            border: 1.5px solid #020220;
            border-radius: 980px;
            transition: all 700ms cubic-bezier(0.32, 0.72, 0, 1);
        }
        .btn-secondary:hover  { background: #020220; color: #ffffff; }
        .btn-secondary:active { transform: scale(0.98); }

        .btn-ghost-light {
            background: transparent;
            color: #ffffff;
            border: 1.5px solid rgba(255,255,255,0.35);
            border-radius: 980px;
            transition: all 700ms cubic-bezier(0.32, 0.72, 0, 1);
        }
        .btn-ghost-light:hover  { background: rgba(255,255,255,0.1); }
        .btn-ghost-light:active { transform: scale(0.98); }

        /* Page Loader - Premium Loading Animation */
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #020220;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 1;
            transition: opacity 0.6s ease-out, visibility 0.6s ease-out;
        }
        .page-loader.hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }
        .loader-logo {
            width: 180px;
            max-width: 50vw;
            height: auto;
            filter: brightness(0) invert(1);
            animation: logoFadeIn 0.8s ease-out;
        }
        @keyframes logoFadeIn {
            0% { opacity: 0; transform: translateY(10px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .loader-bar-track {
            width: 200px;
            max-width: 50vw;
            height: 3px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
            overflow: hidden;
            margin-top: 2rem;
        }
        .loader-bar-fill {
            width: 0%;
            height: 100%;
            background: linear-gradient(90deg, #bb0027, #ff4060);
            border-radius: 4px;
            animation: loaderProgress 0.8s ease-out forwards;
        }
        @keyframes loaderProgress {
            0%   { width: 0%; }
            100% { width: 100%; }
        }

        /* Hide Alpine cloak before init */
        [x-cloak] { display: none !important; }

        /* Floating WhatsApp Button */
        .wa-float {
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            width: 4.5rem;
            height: 4.5rem;
            background: #bb0027;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 14px rgba(187, 0, 39, 0.4);
            z-index: 50;
            transition: all 300ms cubic-bezier(0.32, 0.72, 0, 1);
        }
        .wa-float:hover {
            background: #9a001f;
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(187, 0, 39, 0.5);
        }
        .wa-float:active {
            transform: scale(0.95);
        }
        .wa-float .icon-wrap {
            position: relative;
            width: 1.75rem;
            height: 1.75rem;
        }
        .wa-float .icon-msg,
        .wa-float .icon-phone {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: opacity 400ms ease, transform 400ms ease;
        }
        .wa-float .icon-msg {
            animation: iconCycle 6s ease-in-out infinite;
        }
        .wa-float .icon-phone {
            animation: iconCycleAlt 6s ease-in-out infinite;
        }
        @keyframes iconCycle {
            0%, 45%   { opacity: 1; transform: scale(1) rotate(0deg); }
            50%, 95%  { opacity: 0; transform: scale(0.5) rotate(180deg); }
            100%      { opacity: 1; transform: scale(1) rotate(360deg); }
        }
        @keyframes iconCycleAlt {
            0%, 45%   { opacity: 0; transform: scale(0.5) rotate(-180deg); }
            50%, 95%  { opacity: 1; transform: scale(1) rotate(0deg); }
            100%      { opacity: 0; transform: scale(0.5) rotate(-180deg); }
        }
        .wa-float .wa-tooltip {
            position: absolute;
            right: calc(100% + 0.75rem);
            top: 50%;
            transform: translateY(-50%) translateX(8px);
            background: white;
            color: #0f172a;
            font-family: 'Outfit', sans-serif;
            font-size: 0.8125rem;
            font-weight: 600;
            padding: 0.5rem 0.875rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: all 300ms ease;
        }
        .wa-float:hover .wa-tooltip {
            opacity: 1;
            transform: translateY(-50%) translateX(0);
        }
        .wa-float .wa-tooltip::after {
            content: '';
            position: absolute;
            right: -6px;
            top: 50%;
            transform: translateY(-50%) rotate(45deg);
            width: 12px;
            height: 12px;
            background: white;
            box-shadow: 2px -2px 4px rgba(0,0,0,0.05);
        }
    </style>

    @stack('head')

    <style>
        /* ===== Floating Google Translate Button ===== */
        .gt-float-btn {
            position: fixed;
            bottom: 1.5rem;
            left: 1.5rem;
            width: 4.5rem;
            height: 4.5rem;
            background: #bb0027;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 14px rgba(187, 0, 39, 0.4);
            z-index: 1000;
            cursor: pointer;
            transition: all 300ms cubic-bezier(0.32, 0.72, 0, 1);
            border: none;
            outline: none;
        }
        .gt-float-btn:hover {
            background: #9a001f;
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(187, 0, 39, 0.5);
        }
        .gt-float-btn:active {
            transform: scale(0.95);
        }
        .gt-float-btn svg {
            width: 28px;
            height: 28px;
            fill: white;
        }
        /* Tooltip */
        .gt-float-btn .gt-tooltip {
            position: absolute;
            left: calc(100% + 0.75rem);
            top: 50%;
            transform: translateY(-50%) translateX(-8px);
            background: white;
            color: #0f172a;
            font-family: 'Outfit', sans-serif;
            font-size: 0.8125rem;
            font-weight: 600;
            padding: 0.5rem 0.875rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: all 300ms ease;
        }
        .gt-float-btn:hover .gt-tooltip {
            opacity: 1;
            transform: translateY(-50%) translateX(0);
        }
        .gt-float-btn .gt-tooltip::before {
            content: '';
            position: absolute;
            left: -6px;
            top: 50%;
            transform: translateY(-50%) rotate(45deg);
            width: 12px;
            height: 12px;
            background: white;
            box-shadow: -2px 2px 4px rgba(0,0,0,0.05);
        }

        /* ===== Language Dropdown Panel ===== */
        .gt-panel {
            position: fixed;
            bottom: 7rem;
            left: 1.5rem;
            width: 200px;
            background: #1e2b1a;
            border-radius: 14px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.35);
            z-index: 999;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transform-origin: bottom left;
            transform: scale(0.85) translateY(10px);
            opacity: 0;
            pointer-events: none;
            transition: all 250ms cubic-bezier(0.32, 0.72, 0, 1);
        }
        .gt-panel.open {
            transform: scale(1) translateY(0);
            opacity: 1;
            pointer-events: all;
        }
        .gt-panel-header {
            background: #2d3d28;
            padding: 10px 16px;
            font-family: 'Outfit', sans-serif;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.08em;
            color: rgba(255,255,255,0.6);
            text-transform: uppercase;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .gt-lang-list {
            max-height: 260px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,0.2) transparent;
        }
        .gt-lang-list::-webkit-scrollbar { width: 4px; }
        .gt-lang-list::-webkit-scrollbar-track { background: transparent; }
        .gt-lang-list::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 4px; }
        .gt-lang-item {
            display: flex;
            align-items: center;
            padding: 10px 16px;
            font-family: 'Outfit', sans-serif;
            font-size: 13px;
            font-weight: 500;
            color: #1e293b;
            cursor: pointer;
            transition: background 150ms ease;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }
        .gt-lang-item:hover {
            background: #f1f5f9;
        }
        .gt-lang-item.active {
            background: rgba(187, 0, 39, 0.08);
            color: #bb0027;
            font-weight: 700;
        }
        .gt-lang-item .gt-flag-img {
            width: 22px;
            height: 15px;
            object-fit: cover;
            border-radius: 3px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(0, 0, 0, 0.1);
            flex-shrink: 0;
            margin-right: 10px;
            display: inline-block;
            vertical-align: middle;
        }
        /* Panel footer showing current language */
        .gt-panel-footer {
            background: #2d3d28;
            padding: 10px 16px;
            font-family: 'Outfit', sans-serif;
            font-size: 12px;
            font-weight: 600;
            color: rgba(255,255,255,0.75);
            border-top: 1px solid rgba(255,255,255,0.08);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .gt-panel-footer .gt-current-lang {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .gt-panel-footer .gt-chevron {
            color: rgba(255,255,255,0.4);
            font-size: 14px;
        }


        /* ===== Navbar Translate Button ===== */
        .gt-nav-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 9999px;
            background: transparent;
            border: 1.5px solid rgba(187, 0, 39, 0.35);
            color: #bb0027;
            font-family: 'Outfit', sans-serif;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 220ms ease;
            white-space: nowrap;
        }
        .gt-nav-btn:hover {
            background: #bb0027;
            color: white;
            border-color: #bb0027;
        }
        .gt-nav-btn svg {
            width: 16px;
            height: 16px;
            fill: currentColor;
            flex-shrink: 0;
        }
        .gt-nav-btn .gt-nav-flag-img {
            width: 20px;
            height: 14px;
            object-fit: cover;
            border-radius: 2px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(0, 0, 0, 0.12);
            flex-shrink: 0;
            display: inline-block;
            vertical-align: middle;
        }
        .gt-nav-btn .gt-nav-chevron {
            font-size: 16px;
            transition: transform 220ms ease;
        }
        .gt-nav-btn.open .gt-nav-chevron {
            transform: rotate(180deg);
        }

        /* ===== Navbar Translate Dropdown ===== */
        .gt-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            width: 200px;
            background: #ffffff;
            border-radius: 14px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.15);
            border: 1px solid rgba(0,0,0,0.08);
            z-index: 9999;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transform-origin: top right;
            transform: scale(0.9) translateY(-6px);
            opacity: 0;
            pointer-events: none;
            transition: all 220ms cubic-bezier(0.32, 0.72, 0, 1);
        }
        .gt-dropdown.open {
            transform: scale(1) translateY(0);
            opacity: 1;
            pointer-events: all;
        }
        .gt-dropdown-header {
            background: #f8fafc;
            padding: 9px 14px;
            font-family: 'Outfit', sans-serif;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.08em;
            color: #64748b;
            text-transform: uppercase;
            border-bottom: 1px solid rgba(0,0,0,0.06);
        }
        .gt-lang-list {
            max-height: 240px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: rgba(0,0,0,0.15) transparent;
        }
        .gt-lang-list::-webkit-scrollbar { width: 4px; }
        .gt-lang-list::-webkit-scrollbar-track { background: transparent; }
        .gt-lang-list::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.15); border-radius: 4px; }
        .gt-lang-item {
            display: flex;
            align-items: center;
            padding: 9px 14px;
            font-family: 'Outfit', sans-serif;
            font-size: 13px;
            font-weight: 500;
            color: #1e293b;
            cursor: pointer;
            transition: background 130ms ease;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }
        .gt-lang-item:hover { background: #f1f5f9; }
        .gt-lang-item.active {
            background: rgba(187,0,39,0.08);
            color: #bb0027;
            font-weight: 700;
        }
        .gt-lang-item .gt-flag-img,
        .gt-mobile-lang .gt-flag-img {
            width: 22px;
            height: 15px;
            object-fit: cover;
            border-radius: 3px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(0, 0, 0, 0.1);
            flex-shrink: 0;
            margin-right: 10px;
            display: inline-block;
            vertical-align: middle;
        }

        /* Mobile translate row inside mobile menu */
        .gt-mobile-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 12px;
            border-radius: 10px;
            cursor: pointer;
            transition: background 150ms ease;
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            font-weight: 600;
            color: #bb0027;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }
        .gt-mobile-row:hover { background: rgba(187,0,39,0.06); }
        .gt-mobile-sub {
            display: none;
            flex-direction: column;
            gap: 2px;
            padding-left: 12px;
            margin-top: 6px;
            max-height: 260px;
            overflow-y: auto;
            border-left: 2px solid rgba(187,0,39,0.15);
            margin-left: 12px;
        }
        .gt-mobile-sub.open { display: flex; }
        .gt-mobile-lang {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            border-radius: 8px;
            font-family: 'Outfit', sans-serif;
            font-size: 13px;
            font-weight: 500;
            color: #334155;
            cursor: pointer;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            transition: background 130ms ease;
        }
        .gt-mobile-lang:hover { background: rgba(187,0,39,0.06); }
        .gt-mobile-lang.active { color: #bb0027; font-weight: 700; }

        /* ===== Translate Search Input ===== */
        .gt-search {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            background: #f8fafc;
            border-bottom: 1px solid rgba(0,0,0,0.06);
        }
        .gt-search input {
            flex: 1;
            background: none;
            border: none;
            outline: none;
            font-family: 'Outfit', sans-serif;
            font-size: 13px;
            font-weight: 500;
            color: #1e293b;
        }
        .gt-search input::placeholder {
            color: #94a3b8;
        }
        .gt-search .gt-search-icon {
            color: #94a3b8;
            font-size: 16px;
            flex-shrink: 0;
        }
        .gt-search-clear {
            background: none;
            border: none;
            color: #94a3b8;
            font-size: 16px;
            cursor: pointer;
            padding: 0;
            line-height: 1;
            flex-shrink: 0;
            transition: color 150ms ease;
        }
        .gt-search-clear:hover { color: #64748b; }
        /* Mobile search */
        .gt-mobile-search {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-bottom: 1px solid rgba(0,0,0,0.06);
        }
        .gt-mobile-search input {
            flex: 1;
            background: none;
            border: none;
            outline: none;
            font-family: 'Outfit', sans-serif;
            font-size: 13px;
            font-weight: 500;
            color: #334155;
        }
        .gt-mobile-search input::placeholder { color: #94a3b8; }
        .gt-mobile-search .gt-search-icon {
            color: #94a3b8;
            font-size: 16px;
            flex-shrink: 0;
        }
        .gt-mobile-search .gt-search-clear {
            color: #94a3b8;
        }
        .gt-mobile-search .gt-search-clear:hover { color: #475569; }
        /* No results message */
        .gt-no-results {
            padding: 16px 14px;
            text-align: center;
            font-family: 'Outfit', sans-serif;
            font-size: 12px;
            color: #94a3b8;
        }
        .gt-no-results-mobile {
            padding: 16px 12px;
            text-align: center;
            font-family: 'Outfit', sans-serif;
            font-size: 12px;
            color: #94a3b8;
        }

        /* ===================================================
           HIDE GOOGLE TRANSLATE BANNER — Multi-layer attack
           =================================================== */

        /* 1. The iframe Google injects at the top */
        .goog-te-banner-frame,
        iframe.goog-te-banner-frame,
        .goog-te-banner-frame.skiptranslate {
            display: none !important;
            visibility: hidden !important;
            height: 0 !important;
            max-height: 0 !important;
            overflow: hidden !important;
            pointer-events: none !important;
        }

        /* 2. The body offset Google applies via inline style "top: 40px" */
        body {
            top: 0 !important;
            margin-top: 0 !important;
            padding-top: 0 !important;
        }

        /* 3. Hide any element with class skiptranslate that is a direct child of body
              (Google injects a <div class="skiptranslate goog-te-spinner-pos"> etc.) */
        body > .skiptranslate:not(#google_translate_element) {
            display: none !important;
        }

        /* 4. The hidden widget itself */
        #google_translate_element { display: none !important; }

        /* 5. Gadget cleanup */
        .goog-te-gadget { font-size: 0 !important; }
        .goog-te-gadget > span { display: none !important; }

        /* 6. Notification / status bar Google sometimes renders */
        #goog-gt-tt,
        .goog-te-balloon-frame,
        div#goog-gt-tt {
            display: none !important;
        }
    </style>
</head>
<body class="bg-background text-on-surface font-sans antialiased overflow-x-hidden">

    {{-- GOOGLE TRANSLATE BANNER KILLER — runs immediately before anything else paints --}}
    <script>
        (function () {
            'use strict';

            /* ── Helper: strip banner iframe + reset body top offset ── */
            function killBanner() {
                /* Remove the injected iframe */
                var frames = document.querySelectorAll('iframe.goog-te-banner-frame, .goog-te-banner-frame');
                frames.forEach(function (el) { el.remove(); });

                /* Force body position back to top */
                if (document.body) {
                    document.body.style.setProperty('top',        '0px', 'important');
                    document.body.style.setProperty('margin-top', '0px', 'important');
                }

                /* Remove spinner / skip-translate divs injected by Google */
                var skips = document.querySelectorAll('body > .skiptranslate:not(#google_translate_element)');
                skips.forEach(function (el) { el.style.display = 'none'; });
            }

            /* ── Watch the DOM for Google's dynamic injections ── */
            var observer = new MutationObserver(function () { killBanner(); });

            function startObserver() {
                observer.observe(document.body, {
                    childList:  true,
                    subtree:    true,
                    attributes: true,
                    attributeFilter: ['style', 'class']
                });
                /* Run once immediately */
                killBanner();
            }

            /* Start as soon as <body> is available */
            if (document.body) {
                startObserver();
            } else {
                document.addEventListener('DOMContentLoaded', startObserver);
            }

            /* Also run after full page load to catch late injections */
            window.addEventListener('load', killBanner);
        })();
    </script>

    {{-- PAGE LOADER --}}
    <div id="pageLoader" class="page-loader">
        @if($pengaturan && $pengaturan->logo)
            <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="{{ $pengaturan->company ?? 'Indo Consulting' }}" class="loader-logo">
        @else
            <h2 style="font-family: 'Outfit', sans-serif; font-size: 28px; font-weight: 700; color: #020220;" class="loader-logo">{{ $pengaturan?->company ?? 'Indo Consulting' }}</h2>
        @endif
        <div class="loader-bar-track">
            <div class="loader-bar-fill"></div>
        </div>
    </div>
    {{-- Hide loader instantly on repeat visits (before paint, no flicker) --}}
    <script>
        if (sessionStorage.getItem('ic_visited')) {
            document.getElementById('pageLoader').classList.add('hidden');
        }
    </script>

    {{-- NAVBAR --}}
    <nav id="navbar" class="fixed top-0 w-full z-50 transition-all duration-300 bg-surface/95 backdrop-blur-md border-b border-outline-variant/40 shadow-sm">
        <div class="max-w-container mx-auto px-responsive">
            <div class="flex justify-between items-center h-16 lg:h-18">

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 flex-shrink-0">
                    @if($pengaturan && $pengaturan->logo)
                        <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="{{ $pengaturan->company ?? 'Indo Consulting' }}" class="h-14 w-auto object-contain">
                    @else
                        <span style="font-family: 'Outfit', sans-serif; font-size: 18px; font-weight: 700; color: #020220;">{{ $pengaturan?->company ?? 'Indo Consulting' }}</span>
                    @endif
                </a>

                {{-- Desktop Nav --}}
                <div class="hidden lg:flex items-center gap-1 xl:gap-2">
                    <a href="{{ route('home') }}"
                        class="text-sm xl:text-label-md font-outfit font-semibold text-on-surface-variant hover:text-primary hover:bg-surface-container px-2.5 xl:px-3 py-2 rounded-lg transition-all duration-200 {{ request()->routeIs('home') ? 'nav-active' : '' }}">
                        Home
                    </a>
                    <a href="{{ route('program') }}"
                        class="text-sm xl:text-label-md font-outfit font-semibold text-on-surface-variant hover:text-primary hover:bg-surface-container px-2.5 xl:px-3 py-2 rounded-lg transition-all duration-200 {{ request()->routeIs('program') ? 'nav-active' : '' }}">
                        Program
                    </a>
                    <a href="{{ route('portfolio') }}"
                        class="text-sm xl:text-label-md font-outfit font-semibold text-on-surface-variant hover:text-primary hover:bg-surface-container px-2.5 xl:px-3 py-2 rounded-lg transition-all duration-200 {{ request()->routeIs('portfolio') ? 'nav-active' : '' }}">
                        Portfolio
                    </a>
                    <a href="{{ route('partners-clients') }}"
                        class="text-sm xl:text-label-md font-outfit font-semibold text-on-surface-variant hover:text-primary hover:bg-surface-container px-2.5 xl:px-3 py-2 rounded-lg transition-all duration-200 whitespace-nowrap {{ request()->routeIs('partners-clients') ? 'nav-active' : '' }}">
                        Partners &amp; Clients
                    </a>
                    <a href="{{ route('our-expert') }}"
                        class="text-sm xl:text-label-md font-outfit font-semibold text-on-surface-variant hover:text-primary hover:bg-surface-container px-2.5 xl:px-3 py-2 rounded-lg transition-all duration-200 whitespace-nowrap {{ request()->routeIs('our-expert') ? 'nav-active' : '' }}">
                        Our Expert
                    </a>

                    {{-- INFO DROPDOWN --}}
                    <div class="relative dropdown-trigger">
                        <button
                            class="flex items-center gap-1 text-sm xl:text-label-md font-outfit font-semibold text-on-surface-variant hover:text-primary hover:bg-surface-container px-2.5 xl:px-3 py-2 rounded-lg transition-all duration-200 {{ request()->routeIs('tentang-kami','news-events','gallery') ? 'nav-active' : '' }}"
                            aria-haspopup="true"
                            aria-expanded="false"
                            id="info-dropdown-btn"
                        >
                            Info
                            <span class="material-symbols-outlined text-base leading-none transition-transform duration-200 dropdown-chevron">expand_more</span>
                        </button>
                        <div class="dropdown-menu absolute top-full left-1/2 -translate-x-1/2 mt-3 w-56 bg-surface rounded-xl shadow-lg border border-outline-variant/40 overflow-hidden z-50">
                            <a href="{{ route('tentang-kami') }}"
                                class="flex items-center gap-3 px-4 py-3 text-body-md text-on-surface hover:bg-surface-container hover:text-secondary transition-colors duration-150 {{ request()->routeIs('tentang-kami') ? 'bg-surface-container text-secondary' : '' }}">
                                <span class="material-symbols-outlined text-xl">info</span>
                                Tentang Kami
                            </a>
                            <a href="{{ route('news-events') }}"
                                class="flex items-center gap-3 px-4 py-3 text-body-md text-on-surface hover:bg-surface-container hover:text-secondary transition-colors duration-150 {{ request()->routeIs('news-events') ? 'bg-surface-container text-secondary' : '' }}">
                                <span class="material-symbols-outlined text-xl">newspaper</span>
                                News &amp; Events
                            </a>
                            <a href="{{ route('gallery') }}"
                                class="flex items-center gap-3 px-4 py-3 text-body-md text-on-surface hover:bg-surface-container hover:text-secondary transition-colors duration-150 {{ request()->routeIs('gallery') ? 'bg-surface-container text-secondary' : '' }}">
                                <span class="material-symbols-outlined text-xl">photo_library</span>
                                Gallery
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('kontak-kami') }}"
                        class="text-sm xl:text-label-md font-outfit font-semibold text-on-surface-variant hover:text-primary hover:bg-surface-container px-2.5 xl:px-3 py-2 rounded-lg transition-all duration-200 {{ request()->routeIs('kontak-kami') ? 'nav-active' : '' }}">
                        Kontak
                    </a>
                </div>

                {{-- CTA --}}
                <div class="hidden lg:flex items-center gap-3">

                    {{-- Translate Button (Desktop) --}}
                    <div class="relative" id="gtNavWrap">
                        <button class="gt-nav-btn notranslate" id="gtNavBtn" aria-label="Pilih Bahasa" type="button">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.87 15.07l-2.54-2.51.03-.03c1.74-1.94 2.98-4.17 3.71-6.53H17V4h-7V2H8v2H1v1.99h11.17C11.5 7.92 10.44 9.75 9 11.35 8.07 10.32 7.3 9.19 6.69 8h-2c.73 1.63 1.73 3.17 2.98 4.56l-5.09 5.02L4 19l5-5 3.11 3.11.76-2.04zM18.5 10h-2L12 22h2l1.12-3h4.75L21 22h2l-4.5-12zm-2.62 7l1.62-4.33L19.12 17h-3.24z"/>
                            </svg>
                            <img src="https://flagcdn.com/w40/id.png" alt="Indonesia" class="gt-nav-flag-img" id="gtNavFlag">
                            <span class="gt-nav-chevron material-symbols-outlined">expand_more</span>
                        </button>
                        <div class="gt-dropdown" id="gtDropdown">
                            <div class="gt-dropdown-header notranslate">Pilih Bahasa</div>
                            <div class="gt-search">
                                <span class="material-symbols-outlined gt-search-icon">search</span>
                                <input type="text" id="gtSearchInput" placeholder="Cari bahasa..." autocomplete="off" class="notranslate">
                                <button class="gt-search-clear" id="gtSearchClear" type="button" style="display:none;">
                                    <span class="material-symbols-outlined" style="font-size:14px;">close</span>
                                </button>
                            </div>
                            <div class="gt-lang-list" id="gtLangList"></div>
                        </div>
                    </div>

                    {{-- CTA Button --}}
                    <a href="{{ $waUrl }}"
                       target="_blank" rel="noopener noreferrer"
                       class="btn-primary inline-block px-6 py-2.5 rounded-full text-label-md font-outfit font-semibold shadow-sm">
                        Konsultasi Sekarang
                    </a>
                </div>

                {{-- Mobile Hamburger --}}
                <button id="mobile-toggle" class="lg:hidden p-2 text-on-surface-variant hover:text-primary transition-colors" aria-label="Buka menu">
                    <span class="material-symbols-outlined text-3xl" id="hamburger-icon">menu</span>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="lg:hidden bg-surface border-t border-outline-variant/40">
            <div class="max-w-container mx-auto px-responsive py-4 flex flex-col gap-1">
                <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-3 rounded-lg text-body-md font-semibold text-on-surface hover:bg-surface-container hover:text-secondary transition-colors {{ request()->routeIs('home') ? 'bg-surface-container text-secondary' : '' }}">
                    <span class="material-symbols-outlined text-xl">home</span> Home
                </a>
                <a href="{{ route('program') }}" class="flex items-center gap-3 px-3 py-3 rounded-lg text-body-md font-semibold text-on-surface hover:bg-surface-container hover:text-secondary transition-colors {{ request()->routeIs('program') ? 'bg-surface-container text-secondary' : '' }}">
                    <span class="material-symbols-outlined text-xl">school</span> Program
                </a>
                <a href="{{ route('portfolio') }}" class="flex items-center gap-3 px-3 py-3 rounded-lg text-body-md font-semibold text-on-surface hover:bg-surface-container hover:text-secondary transition-colors {{ request()->routeIs('portfolio') ? 'bg-surface-container text-secondary' : '' }}">
                    <span class="material-symbols-outlined text-xl">work</span> Portfolio
                </a>
                <a href="{{ route('partners-clients') }}" class="flex items-center gap-3 px-3 py-3 rounded-lg text-body-md font-semibold text-on-surface hover:bg-surface-container hover:text-secondary transition-colors {{ request()->routeIs('partners-clients') ? 'bg-surface-container text-secondary' : '' }}">
                    <span class="material-symbols-outlined text-xl">handshake</span> Partners &amp; Clients
                </a>
                <a href="{{ route('our-expert') }}" class="flex items-center gap-3 px-3 py-3 rounded-lg text-body-md font-semibold text-on-surface hover:bg-surface-container hover:text-secondary transition-colors {{ request()->routeIs('our-expert') ? 'bg-surface-container text-secondary' : '' }}">
                    <span class="material-symbols-outlined text-xl">groups</span> Our Expert
                </a>

                {{-- Mobile Info accordion --}}
                <div x-data="{ open: false }">
                    <button
                        id="mobile-info-btn"
                        onclick="toggleMobileInfo()"
                        class="flex items-center justify-between w-full px-3 py-3 rounded-lg text-body-md font-semibold text-on-surface hover:bg-surface-container hover:text-secondary transition-colors {{ request()->routeIs('tentang-kami','news-events','gallery') ? 'bg-surface-container text-secondary' : '' }}">
                        <span class="flex items-center gap-3"><span class="material-symbols-outlined text-xl">info</span> Info</span>
                        <span class="material-symbols-outlined text-xl transition-transform duration-200" id="mobile-info-chevron">expand_more</span>
                    </button>
                    <div id="mobile-info-submenu" class="hidden pl-10 flex flex-col gap-1 mt-1">
                        <a href="{{ route('tentang-kami') }}" class="px-3 py-2.5 rounded-lg text-body-md text-on-surface-variant hover:bg-surface-container hover:text-secondary transition-colors {{ request()->routeIs('tentang-kami') ? 'text-secondary font-semibold' : '' }}">Tentang Kami</a>
                        <a href="{{ route('news-events') }}" class="px-3 py-2.5 rounded-lg text-body-md text-on-surface-variant hover:bg-surface-container hover:text-secondary transition-colors {{ request()->routeIs('news-events') ? 'text-secondary font-semibold' : '' }}">News &amp; Events</a>
                        <a href="{{ route('gallery') }}" class="px-3 py-2.5 rounded-lg text-body-md text-on-surface-variant hover:bg-surface-container hover:text-secondary transition-colors {{ request()->routeIs('gallery') ? 'text-secondary font-semibold' : '' }}">Gallery</a>
                    </div>
                </div>

                <a href="{{ route('kontak-kami') }}" class="flex items-center gap-3 px-3 py-3 rounded-lg text-body-md font-semibold text-on-surface hover:bg-surface-container hover:text-secondary transition-colors {{ request()->routeIs('kontak-kami') ? 'bg-surface-container text-secondary' : '' }}">
                    <span class="material-symbols-outlined text-xl">contact_page</span> Kontak
                </a>

                <div class="pt-3 border-t border-outline-variant/30 mt-2">
                    <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" class="btn-primary block text-center px-6 py-3 rounded-lg text-label-md font-outfit font-semibold">
                        Konsultasi Sekarang
                    </a>
                </div>

                {{-- Mobile Translate --}}
                <div class="border-t border-outline-variant/30 mt-2 pt-2">
                    <button class="gt-mobile-row notranslate" id="gtMobileToggle" type="button">
                        <span class="material-symbols-outlined text-xl">translate</span>
                        <span class="notranslate inline-flex items-center gap-2">Terjemahkan &nbsp;<img src="https://flagcdn.com/w40/id.png" alt="Indonesia" class="gt-nav-flag-img" id="gtMobileFlag"> <span id="gtMobileName">Indonesia</span></span>
                        <span class="material-symbols-outlined text-base ml-auto" id="gtMobileChevron">expand_more</span>
                    </button>
                    <div class="gt-mobile-sub" id="gtMobileSub">
                        <div class="gt-mobile-search">
                            <span class="material-symbols-outlined gt-search-icon">search</span>
                            <input type="text" id="gtMobileSearchInput" placeholder="Cari bahasa..." autocomplete="off">
                            <button class="gt-search-clear" id="gtMobileSearchClear" type="button" style="display:none;">
                                <span class="material-symbols-outlined" style="font-size:14px;">close</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    {{-- PAGE CONTENT --}}
    <main class="pt-16 lg:pt-18">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-primary text-on-primary">
        <div class="max-w-container mx-auto px-responsive pt-16 pb-8">
            {{-- Footer top --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 pb-12 border-b border-white/10">
                {{-- Brand --}}
                <div class="lg:col-span-2">
                    @if($pengaturan && $pengaturan->logo)
                        <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="{{ $pengaturan->company ?? 'Indo Consulting' }}" class="h-12 object-contain brightness-0 invert mb-5">
                    @else
                        <h3 class="text-headline-sm font-outfit font-bold text-white mb-4">{{ $pengaturan?->company ?? 'Indo Consulting' }}</h3>
                    @endif
                    <p class="text-body-md text-white/60 max-w-xs leading-relaxed mb-6">
                        Mitra strategis terpercaya untuk solusi bisnis inovatif, mendukung pertumbuhan perusahaan di berbagai industri.
                    </p>
                    <div class="flex items-center gap-3">
                        @foreach($socialMedia as $sm)
                            @php
                                $smUrl = $sm->url;
                                if ($sm->platform === 'whatsapp' && empty($smUrl)) {
                                    $smUrl = $waUrl;
                                }
                            @endphp
                            @if($smUrl)
                                <a href="{{ $smUrl }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-lg bg-white/10 flex items-center justify-center hover:bg-secondary transition-colors duration-200" aria-label="{{ $sm->label }}">
                                    @if($sm->platform === 'instagram')
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                                    @elseif($sm->platform === 'youtube')
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="text-white"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                    @elseif($sm->platform === 'whatsapp')
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="text-white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
                                    @endif
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>

                {{-- Navigasi --}}
                <div>
                    <h4 class="text-label-md font-outfit uppercase tracking-wider text-white/40 mb-5">Navigasi</h4>
                    <ul class="flex flex-col gap-3">
                        <li><a href="{{ route('home') }}" class="text-body-md text-white/65 hover:text-white transition-colors">Home</a></li>
                        <li><a href="{{ route('program') }}" class="text-body-md text-white/65 hover:text-white transition-colors">Program</a></li>
                        <li><a href="{{ route('portfolio') }}" class="text-body-md text-white/65 hover:text-white transition-colors">Portfolio</a></li>
                        <li><a href="{{ route('partners-clients') }}" class="text-body-md text-white/65 hover:text-white transition-colors">Partners &amp; Clients</a></li>
                        <li><a href="{{ route('kontak-kami') }}" class="text-body-md text-white/65 hover:text-white transition-colors">Kontak</a></li>
                    </ul>
                </div>

                {{-- Info --}}
                <div>
                    <h4 class="text-label-md font-outfit uppercase tracking-wider text-white/40 mb-5">Info</h4>
                    <ul class="flex flex-col gap-3">
                        <li><a href="{{ route('tentang-kami') }}" class="text-body-md text-white/65 hover:text-white transition-colors">Tentang Kami</a></li>
                        <li><a href="{{ route('our-expert') }}" class="text-body-md text-white/65 hover:text-white transition-colors">Our Expert</a></li>
                        <li><a href="{{ route('news-events') }}" class="text-body-md text-white/65 hover:text-white transition-colors">News &amp; Events</a></li>
                        <li><a href="{{ route('gallery') }}" class="text-body-md text-white/65 hover:text-white transition-colors">Gallery</a></li>
                    </ul>
                </div>

                {{-- Kontak --}}
                <div>
                    <h4 class="text-label-md font-outfit uppercase tracking-wider text-white/40 mb-5">Hubungi Kami</h4>
                    <ul class="flex flex-col gap-4">
                        @if($pengaturan && $pengaturan->phone)
                        <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-secondary text-xl mt-0.5 flex-shrink-0">call</span>
                            <span class="text-body-md text-white/65">{{ $pengaturan->phone }}</span>
                        </li>
                        @endif
                        @if($pengaturan && $pengaturan->email)
                        <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-secondary text-xl mt-0.5 flex-shrink-0">mail</span>
                            <span class="text-body-md text-white/65">{{ $pengaturan->email }}</span>
                        </li>
                        @endif
                        @if($pengaturan && $pengaturan->address)
                        <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-secondary text-xl mt-0.5 flex-shrink-0">location_on</span>
                            <span class="text-body-md text-white/65">{{ $pengaturan->address }}</span>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>

            {{-- Footer bottom --}}
            <div class="pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-label-sm text-white/40">
                    {!! $pengaturan?->copyright ?? '&copy; ' . date('Y') . ' Indo Consulting. Hak cipta dilindungi.' !!}
                </p>
            </div>
        </div>
    </footer>

    {{-- Scripts --}}
    <script>
        // Mobile menu toggle
        const mobileToggle = document.getElementById('mobile-toggle');
        const mobileMenu   = document.getElementById('mobile-menu');
        const hamburgerIcon = document.getElementById('hamburger-icon');

        mobileToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('open');
            hamburgerIcon.textContent = mobileMenu.classList.contains('open') ? 'close' : 'menu';
        });

        function closeMobileMenu() {
            if (mobileMenu) mobileMenu.classList.remove('open');
            if (hamburgerIcon) hamburgerIcon.textContent = 'menu';
        }

        // Mobile info submenu
        function toggleMobileInfo() {
            const submenu = document.getElementById('mobile-info-submenu');
            const chevron = document.getElementById('mobile-info-chevron');
            submenu.classList.toggle('hidden');
            chevron.style.transform = submenu.classList.contains('hidden') ? '' : 'rotate(180deg)';
        }

        // Scroll reveal
        const reveals = document.querySelectorAll('.reveal');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, i) => {
                if (entry.isIntersecting) {
                    setTimeout(() => entry.target.classList.add('visible'), entry.target.dataset.delay || 0);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });
        reveals.forEach(el => observer.observe(el));

        // Stagger reveal for children
        document.querySelectorAll('[data-stagger]').forEach(container => {
            const children = container.querySelectorAll('.reveal');
            children.forEach((child, i) => {
                child.dataset.delay = i * 80;
            });
        });

        // PAGE LOADER — first visit only (per session)
        const pageLoader = document.getElementById('pageLoader');
        function dismissLoader() {
            pageLoader.classList.add('hidden');
            sessionStorage.setItem('ic_visited', '1');
        }
        window.addEventListener('load', () => setTimeout(dismissLoader, 600));
        setTimeout(dismissLoader, 3000);
    </script>

    {{-- Floating Contact Button --}}
    @php
        $waPhone = $pengaturan ? preg_replace('/[^0-9]/', '', $pengaturan->phone) : '6287865309966';
        $contactEmail = $pengaturan ? $pengaturan->email : 'info@indoconsulting.id';
    @endphp

    {{-- Floating Button --}}
    <button id="floatContactBtn" onclick="toggleContactPopup(event)" aria-label="Hubungi Kami" class="wa-float">
        <div class="icon-wrap">
            <span class="icon-msg">
                <span class="material-symbols-outlined" style="font-size: 28px;">chat_bubble</span>
            </span>
            <span class="icon-phone">
                <span class="material-symbols-outlined" style="font-size: 28px;">call</span>
            </span>
        </div>
        <span class="wa-tooltip">Hubungi Kami</span>
    </button>

    {{-- Contact Popup --}}
    <div id="floatContactPopup" style="display:none; width:280px; position:fixed; bottom:6rem; right:1.5rem; background:white; border-radius:1rem; box-shadow:0 20px 60px rgba(0,0,0,0.15); overflow:hidden; z-index:9999; transition: opacity 200ms ease, transform 200ms ease; opacity:0; transform: scale(0.95) translateY(8px);">
        <div style="background:#bb0027; padding:1rem 1.25rem; color:white;">
            <h3 style="font-family:'Outfit',sans-serif; font-weight:700; font-size:1.1rem; margin:0 0 4px 0;">Hubungi Kami</h3>
            <p style="font-family:'Outfit',sans-serif; font-size:0.8rem; color:rgba(255,255,255,0.75); margin:0;">Pilih metode komunikasi</p>
        </div>
        <div style="padding:0.75rem; display:flex; flex-direction:column; gap:0.5rem;">
            {{-- WhatsApp --}}
            <a href="{{ $waUrl }}"
               target="_blank" rel="noopener noreferrer"
               onclick="event.stopPropagation();"
               style="display:flex; align-items:center; gap:0.75rem; padding:0.75rem; border-radius:0.75rem; background:#f0fdf4; text-decoration:none; transition:background 200ms;">
                <div style="width:40px; height:40px; background:#22c55e; border-radius:9999px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
                </div>
                <div style="flex:1;">
                    <p style="font-family:'Outfit',sans-serif; font-weight:600; font-size:0.875rem; color:#111827; margin:0 0 2px 0;">WhatsApp</p>
                    <p style="font-family:'Outfit',sans-serif; font-size:0.75rem; color:#6b7280; margin:0;">Chat langsung</p>
                </div>
                <span class="material-symbols-outlined" style="font-size:18px; color:#9ca3af;">arrow_forward</span>
            </a>

            {{-- Email --}}
            <a href="mailto:{{ $contactEmail }}?subject=Konsultasi Indo Consulting"
               onclick="event.stopPropagation();"
               style="display:flex; align-items:center; gap:0.75rem; padding:0.75rem; border-radius:0.75rem; background:#eff6ff; text-decoration:none; transition:background 200ms;">
                <div style="width:40px; height:40px; background:#3b82f6; border-radius:9999px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <span class="material-symbols-outlined" style="font-size:20px; color:white;">email</span>
                </div>
                <div style="flex:1;">
                    <p style="font-family:'Outfit',sans-serif; font-weight:600; font-size:0.875rem; color:#111827; margin:0 0 2px 0;">Email</p>
                    <p style="font-family:'Outfit',sans-serif; font-size:0.75rem; color:#6b7280; margin:0;">Kirim pesan</p>
                </div>
                <span class="material-symbols-outlined" style="font-size:18px; color:#9ca3af;">arrow_forward</span>
            </a>
        </div>
    </div>

    <script>
        (function() {
            var _popupOpen = false;

            window.toggleContactPopup = function(e) {
                if (e) { e.stopPropagation(); e.preventDefault(); }
                var popup = document.getElementById('floatContactPopup');
                if (!popup) return;
                if (_popupOpen) {
                    closeContactPopup();
                } else {
                    openContactPopup();
                }
            };

            function openContactPopup() {
                var popup = document.getElementById('floatContactPopup');
                if (!popup) return;
                popup.style.display = 'block';
                // Force reflow before applying transition
                popup.offsetHeight;
                popup.style.opacity = '1';
                popup.style.transform = 'scale(1) translateY(0)';
                _popupOpen = true;
            }

            function closeContactPopup() {
                var popup = document.getElementById('floatContactPopup');
                if (!popup) return;
                popup.style.opacity = '0';
                popup.style.transform = 'scale(0.95) translateY(8px)';
                setTimeout(function() {
                    if (!_popupOpen) popup.style.display = 'none';
                }, 200);
                _popupOpen = false;
            }

            // Close when clicking outside
            document.addEventListener('click', function(e) {
                if (!_popupOpen) return;
                var btn = document.getElementById('floatContactBtn');
                var popup = document.getElementById('floatContactPopup');
                if (btn && btn.contains(e.target)) return;
                if (popup && popup.contains(e.target)) return;
                closeContactPopup();
            });

            // Close on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && _popupOpen) closeContactPopup();
            });
        })();
    </script>

    {{-- Google Translate (hidden widget - controlled by custom navbar button) --}}
    <div id="google_translate_element" style="display:none;"></div>

    {{-- Alpine.js Debug Script --}}
    <script>
        document.addEventListener('alpine:init', () => {
            console.log('Alpine.js initialized successfully');
        });
    </script>

    <script>
        // ─── Language list ──────────────────────────────────────────────────────
        const GT_LANGUAGES = [
            { code: 'id', name: 'Indonesia', flagCode: 'id' },
            { code: 'en', name: 'Inggris', flagCode: 'us' },
            { code: 'af', name: 'Afrikaans', flagCode: 'za' },
            { code: 'sq', name: 'Albania', flagCode: 'al' },
            { code: 'am', name: 'Amharik', flagCode: 'et' },
            { code: 'ar', name: 'Arab', flagCode: 'sa' },
            { code: 'hy', name: 'Armenia', flagCode: 'am' },
            { code: 'az', name: 'Azerbaijan', flagCode: 'az' },
            { code: 'eu', name: 'Basque', flagCode: 'es' },
            { code: 'be', name: 'Belarusia', flagCode: 'by' },
            { code: 'bn', name: 'Bengali', flagCode: 'bd' },
            { code: 'bs', name: 'Bosnia', flagCode: 'ba' },
            { code: 'bg', name: 'Bulgaria', flagCode: 'bg' },
            { code: 'ca', name: 'Katala', flagCode: 'es' },
            { code: 'ceb', name: 'Cebuano', flagCode: 'ph' },
            { code: 'zh-CN', name: 'Mandarin (Sederhana)', flagCode: 'cn' },
            { code: 'zh-TW', name: 'Mandarin (Tradisional)', flagCode: 'tw' },
            { code: 'co', name: 'Korsika', flagCode: 'fr' },
            { code: 'hr', name: 'Kroasia', flagCode: 'hr' },
            { code: 'cs', name: 'Ceko', flagCode: 'cz' },
            { code: 'da', name: 'Denmark', flagCode: 'dk' },
            { code: 'nl', name: 'Belanda', flagCode: 'nl' },
            { code: 'eo', name: 'Esperanto', flagCode: 'un' },
            { code: 'et', name: 'Estonia', flagCode: 'ee' },
            { code: 'fi', name: 'Finlandia', flagCode: 'fi' },
            { code: 'fr', name: 'Perancis', flagCode: 'fr' },
            { code: 'fy', name: 'Frisia', flagCode: 'nl' },
            { code: 'gl', name: 'Galisia', flagCode: 'es' },
            { code: 'ka', name: 'Georgia', flagCode: 'ge' },
            { code: 'de', name: 'Jerman', flagCode: 'de' },
            { code: 'el', name: 'Yunani', flagCode: 'gr' },
            { code: 'gu', name: 'Gujarat', flagCode: 'in' },
            { code: 'ht', name: 'Kreol Haiti', flagCode: 'ht' },
            { code: 'ha', name: 'Hausa', flagCode: 'ng' },
            { code: 'haw', name: 'Hawaii', flagCode: 'us' },
            { code: 'he', name: 'Ibrani', flagCode: 'il' },
            { code: 'hi', name: 'Hindi', flagCode: 'in' },
            { code: 'hmn', name: 'Hmong', flagCode: 'la' },
            { code: 'hu', name: 'Hungaria', flagCode: 'hu' },
            { code: 'is', name: 'Islandia', flagCode: 'is' },
            { code: 'ig', name: 'Igbo', flagCode: 'ng' },
            { code: 'ga', name: 'Irlandia', flagCode: 'ie' },
            { code: 'it', name: 'Italia', flagCode: 'it' },
            { code: 'ja', name: 'Jepang', flagCode: 'jp' },
            { code: 'jv', name: 'Jawa', flagCode: 'id' },
            { code: 'kn', name: 'Kannada', flagCode: 'in' },
            { code: 'kk', name: 'Kazakhstan', flagCode: 'kz' },
            { code: 'km', name: 'Khmer', flagCode: 'kh' },
            { code: 'rw', name: 'Kinyarwanda', flagCode: 'rw' },
            { code: 'ko', name: 'Korea', flagCode: 'kr' },
            { code: 'ku', name: 'Kurdi', flagCode: 'iq' },
            { code: 'ky', name: 'Kirgiz', flagCode: 'kg' },
            { code: 'lo', name: 'Laos', flagCode: 'la' },
            { code: 'la', name: 'Latin', flagCode: 'va' },
            { code: 'lv', name: 'Latvia', flagCode: 'lv' },
            { code: 'lt', name: 'Lithuania', flagCode: 'lt' },
            { code: 'lb', name: 'Luksemburg', flagCode: 'lu' },
            { code: 'mk', name: 'Makedonia', flagCode: 'mk' },
            { code: 'mg', name: 'Malagasi', flagCode: 'mg' },
            { code: 'ms', name: 'Melayu', flagCode: 'my' },
            { code: 'ml', name: 'Malayalam', flagCode: 'in' },
            { code: 'mt', name: 'Malta', flagCode: 'mt' },
            { code: 'mi', name: 'Maori', flagCode: 'nz' },
            { code: 'mr', name: 'Marathi', flagCode: 'in' },
            { code: 'mn', name: 'Mongolia', flagCode: 'mn' },
            { code: 'my', name: 'Myanmar', flagCode: 'mm' },
            { code: 'ne', name: 'Nepal', flagCode: 'np' },
            { code: 'no', name: 'Norwegia', flagCode: 'no' },
            { code: 'ny', name: 'Chichewa', flagCode: 'mw' },
            { code: 'or', name: 'Odia', flagCode: 'in' },
            { code: 'ps', name: 'Pashto', flagCode: 'af' },
            { code: 'fa', name: 'Persia', flagCode: 'ir' },
            { code: 'pl', name: 'Polandia', flagCode: 'pl' },
            { code: 'pt', name: 'Portugis', flagCode: 'br' },
            { code: 'pa', name: 'Punjabi', flagCode: 'in' },
            { code: 'ro', name: 'Rumania', flagCode: 'ro' },
            { code: 'ru', name: 'Rusia', flagCode: 'ru' },
            { code: 'sm', name: 'Samoa', flagCode: 'ws' },
            { code: 'gd', name: 'Gaelik Skotlandia', flagCode: 'gb' },
            { code: 'sr', name: 'Serbia', flagCode: 'rs' },
            { code: 'st', name: 'Sesotho', flagCode: 'ls' },
            { code: 'sn', name: 'Shona', flagCode: 'zw' },
            { code: 'sd', name: 'Sindhi', flagCode: 'pk' },
            { code: 'si', name: 'Sinhala', flagCode: 'lk' },
            { code: 'sk', name: 'Slovak', flagCode: 'sk' },
            { code: 'sl', name: 'Slovenia', flagCode: 'si' },
            { code: 'so', name: 'Somali', flagCode: 'so' },
            { code: 'es', name: 'Spanyol', flagCode: 'es' },
            { code: 'su', name: 'Sunda', flagCode: 'id' },
            { code: 'sw', name: 'Swahili', flagCode: 'tz' },
            { code: 'sv', name: 'Swedia', flagCode: 'se' },
            { code: 'tl', name: 'Filipino', flagCode: 'ph' },
            { code: 'tg', name: 'Tajik', flagCode: 'tj' },
            { code: 'ta', name: 'Tamil', flagCode: 'in' },
            { code: 'tt', name: 'Tatar', flagCode: 'ru' },
            { code: 'te', name: 'Telugu', flagCode: 'in' },
            { code: 'th', name: 'Thailand', flagCode: 'th' },
            { code: 'tr', name: 'Turki', flagCode: 'tr' },
            { code: 'tk', name: 'Turkmen', flagCode: 'tm' },
            { code: 'uk', name: 'Ukraina', flagCode: 'ua' },
            { code: 'ur', name: 'Urdu', flagCode: 'pk' },
            { code: 'ug', name: 'Uighur', flagCode: 'cn' },
            { code: 'uz', name: 'Uzbek', flagCode: 'uz' },
            { code: 'vi', name: 'Vietnam', flagCode: 'vn' },
            { code: 'cy', name: 'Wales', flagCode: 'gb' },
            { code: 'xh', name: 'Xhosa', flagCode: 'za' },
            { code: 'yi', name: 'Yiddish', flagCode: 'il' },
            { code: 'yo', name: 'Yoruba', flagCode: 'ng' },
            { code: 'zu', name: 'Zulu', flagCode: 'za' },
        ];

        let gtCurrentCode = 'id';
        let gtOpen = false;

        // ─── Detect saved language from cookie ─────────────────────────────────
        (function detectCurrentLang() {
            const match = document.cookie.match(/googtrans=\/[a-z-]+\/([a-zA-Z-]+)/);
            if (match) {
                const code = match[1];
                const found = GT_LANGUAGES.find(l => l.code === code);
                if (found) gtCurrentCode = found.code;
            }
        })();

        // ─── Render desktop dropdown list ──────────────────────────────────────
        let gtSearchQuery = '';
        function gtRenderList(query) {
            const list = document.getElementById('gtLangList');
            if (!list) return;
            list.innerHTML = '';
            const q = (query || '').toLowerCase();
            const filtered = q ? GT_LANGUAGES.filter(l => l.name.toLowerCase().includes(q) || l.code.toLowerCase().includes(q)) : GT_LANGUAGES;
            if (filtered.length === 0) {
                list.innerHTML = '<div class="gt-no-results">Bahasa tidak ditemukan</div>';
                return;
            }
            filtered.forEach(lang => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'gt-lang-item' + (lang.code === gtCurrentCode ? ' active' : '');
                btn.dataset.code = lang.code;
                
                // Create flag image
                const flagImg = document.createElement('img');
                flagImg.className = 'gt-flag-img';
                flagImg.src = `https://flagcdn.com/w40/${lang.flagCode}.png`;
                flagImg.alt = lang.name;
                flagImg.loading = 'lazy';
                
                // Create name span
                const nameSpan = document.createElement('span');
                nameSpan.className = 'notranslate';
                nameSpan.innerText = lang.name;
                
                btn.appendChild(flagImg);
                btn.appendChild(nameSpan);
                btn.addEventListener('click', () => gtSelectLang(lang));
                list.appendChild(btn);
            });
        }

        // ─── Render mobile language list ───────────────────────────────────────
        let gtMobileSearchQuery = '';
        function gtRenderMobileList(query) {
            const sub = document.getElementById('gtMobileSub');
            if (!sub) return;
            // Preserve search input when re-rendering
            const existingSearch = sub.querySelector('.gt-mobile-search');
            sub.innerHTML = '';
            // Rebuild search input
            const searchDiv = document.createElement('div');
            searchDiv.className = 'gt-mobile-search';
            searchDiv.innerHTML = '<span class="material-symbols-outlined gt-search-icon">search</span>' +
                '<input type="text" id="gtMobileSearchInput" placeholder="Cari bahasa..." autocomplete="off">' +
                '<button class="gt-search-clear" id="gtMobileSearchClear" type="button" style="display:none;">' +
                '<span class="material-symbols-outlined" style="font-size:14px;">close</span></button>';
            sub.appendChild(searchDiv);
            // Restore search value and events
            const mInput = document.getElementById('gtMobileSearchInput');
            const mClear = document.getElementById('gtMobileSearchClear');
            if (mInput) {
                mInput.value = gtMobileSearchQuery;
                mInput.addEventListener('input', function() {
                    gtMobileSearchQuery = this.value;
                    if (mClear) mClear.style.display = this.value ? 'flex' : 'none';
                    gtRenderMobileList(this.value);
                    // Re-focus and restore cursor position
                    const newInput = document.getElementById('gtMobileSearchInput');
                    if (newInput) { newInput.focus(); newInput.setSelectionRange(newInput.value.length, newInput.value.length); }
                });
            }
            if (mClear) {
                mClear.addEventListener('click', function() {
                    gtMobileSearchQuery = '';
                    gtRenderMobileList('');
                    const newInput = document.getElementById('gtMobileSearchInput');
                    if (newInput) newInput.focus();
                });
            }
            // Render filtered list
            const q = (query || '').toLowerCase();
            const filtered = q ? GT_LANGUAGES.filter(l => l.name.toLowerCase().includes(q) || l.code.toLowerCase().includes(q)) : GT_LANGUAGES;
            if (filtered.length === 0) {
                const noRes = document.createElement('div');
                noRes.className = 'gt-no-results-mobile';
                noRes.textContent = 'Bahasa tidak ditemukan';
                sub.appendChild(noRes);
                return;
            }
            filtered.forEach(lang => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'gt-mobile-lang' + (lang.code === gtCurrentCode ? ' active' : '');
                btn.dataset.code = lang.code;
                
                // Create flag image
                const flagImg = document.createElement('img');
                flagImg.className = 'gt-flag-img';
                flagImg.src = `https://flagcdn.com/w40/${lang.flagCode}.png`;
                flagImg.alt = lang.name;
                flagImg.loading = 'lazy';
                
                // Create name span
                const nameSpan = document.createElement('span');
                nameSpan.className = 'notranslate';
                nameSpan.innerText = lang.name;
                
                btn.appendChild(flagImg);
                btn.appendChild(nameSpan);
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    gtSelectLang(lang);
                });
                sub.appendChild(btn);
            });
        }

        // ─── Update all flag/name UI indicators ────────────────────────────────
        function gtUpdateIndicators() {
            const lang = GT_LANGUAGES.find(l => l.code === gtCurrentCode) || GT_LANGUAGES[0];
            const flagUrl = `https://flagcdn.com/w40/${lang.flagCode}.png`;
            const navFlag = document.getElementById('gtNavFlag');
            if (navFlag) {
                navFlag.src = flagUrl;
                navFlag.alt = lang.name;
            }
            const mFlag = document.getElementById('gtMobileFlag');
            if (mFlag) {
                mFlag.src = flagUrl;
                mFlag.alt = lang.name;
            }
            const mName = document.getElementById('gtMobileName');
            if (mName) mName.innerHTML = '<span class="notranslate">' + lang.name + '</span>';
        }

        // ─── Select a language ─────────────────────────────────────────────────
        function gtSelectLang(lang) {
            gtCurrentCode = lang.code;
            gtUpdateIndicators();

            // Update active state on desktop list without full re-render
            const desktopItems = document.querySelectorAll('#gtLangList .gt-lang-item');
            desktopItems.forEach(function(item) {
                item.classList.toggle('active', item.dataset.code === lang.code);
            });

            // Update active state on mobile list without full re-render
            const mobileItems = document.querySelectorAll('#gtMobileSub .gt-mobile-lang');
            mobileItems.forEach(function(item) {
                item.classList.toggle('active', item.dataset.code === lang.code);
            });

            // Tutup dropdown desktop dan mobile menu
            gtClose();
            closeMobileMenu();

            // Jalankan operasi terjemahan setelah DOM selesai
            setTimeout(function() {
                // ── Kembali ke bahasa Indonesia (tampilan asli) ────────────────────
                if (lang.code === 'id') {
                    // Strategi 1: Gunakan combo Google Translate dengan nilai kosong untuk restore
                    const combo = document.querySelector('.goog-te-combo');
                    if (combo) {
                        combo.value = '';
                        combo.dispatchEvent(new Event('change'));
                    }

                    // Strategi 2: Coba gunakan API restore resmi Google Translate
                    try {
                        const instance = google.translate.TranslateElement.getInstance();
                        if (instance && instance.restore) {
                            instance.restore();
                        }
                    } catch(e) {}

                    // Strategi 3 (paling andal): Hapus cookie googtrans dan reload halaman
                    document.cookie = 'googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/';
                    document.cookie = 'googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=' + location.hostname;
                    document.cookie = 'googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=.' + location.hostname;
                    window.location.reload();
                    return;
                }

                // ── Pindah ke bahasa lain ──────────────────────────────────────────
                const combo = document.querySelector('.goog-te-combo');
                if (combo) {
                    combo.value = lang.code;
                    combo.dispatchEvent(new Event('change'));
                } else {
                    document.cookie = `googtrans=/id/${lang.code}; path=/`;
                    document.cookie = `googtrans=/id/${lang.code}; path=/; domain=${location.hostname}`;
                    window.location.reload();
                }
            }, 80);
        }

        // ─── Toggle / Close dropdown ───────────────────────────────────────────
        function gtToggle() {
            gtOpen = !gtOpen;
            const btn = document.getElementById('gtNavBtn');
            const dd  = document.getElementById('gtDropdown');
            if (btn) btn.classList.toggle('open', gtOpen);
            if (dd)  dd.classList.toggle('open', gtOpen);
        }
        function gtClose() {
            gtOpen = false;
            const btn = document.getElementById('gtNavBtn');
            const dd  = document.getElementById('gtDropdown');
            if (btn) btn.classList.remove('open');
            if (dd)  dd.classList.remove('open');
            // Reset search
            gtSearchQuery = '';
            const si = document.getElementById('gtSearchInput');
            const sc = document.getElementById('gtSearchClear');
            if (si) si.value = '';
            if (sc) sc.style.display = 'none';
            gtRenderList('');
        }

        // ─── Mobile accordion toggle ───────────────────────────────────────────
        document.addEventListener('DOMContentLoaded', function () {
            var mToggle = document.getElementById('gtMobileToggle');
            if (mToggle) {
                mToggle.addEventListener('click', function () {
                    var sub = document.getElementById('gtMobileSub');
                    var chev = document.getElementById('gtMobileChevron');
                    var isOpen = sub.classList.toggle('open');
                    if (chev) chev.style.transform = isOpen ? 'rotate(180deg)' : '';
                });
            }

            // Desktop button
            var navBtn = document.getElementById('gtNavBtn');
            if (navBtn) navBtn.addEventListener('click', function(e) { e.stopPropagation(); gtToggle(); });

            // Desktop search
            var gtSearchInput = document.getElementById('gtSearchInput');
            var gtSearchClear = document.getElementById('gtSearchClear');
            if (gtSearchInput) {
                gtSearchInput.addEventListener('input', function() {
                    gtSearchQuery = this.value;
                    if (gtSearchClear) gtSearchClear.style.display = this.value ? 'flex' : 'none';
                    gtRenderList(this.value);
                    // Re-focus
                    var newInput = document.getElementById('gtSearchInput');
                    if (newInput) { newInput.focus(); newInput.setSelectionRange(newInput.value.length, newInput.value.length); }
                });
                gtSearchInput.addEventListener('click', function(e) { e.stopPropagation(); });
            }
            if (gtSearchClear) {
                gtSearchClear.addEventListener('click', function(e) {
                    e.stopPropagation();
                    gtSearchQuery = '';
                    gtRenderList('');
                    if (gtSearchInput) { gtSearchInput.value = ''; gtSearchInput.focus(); }
                });
            }

            // Close on outside click
            document.addEventListener('click', function(e) {
                var wrap = document.getElementById('gtNavWrap');
                if (wrap && !wrap.contains(e.target)) gtClose();
            });

            // Init render
            gtUpdateIndicators();
            gtRenderList();
            gtRenderMobileList();
        });

        // ─── Init Google Translate widget (hidden) ─────────────────────────────
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'id',
                includedLanguages: '',
                autoDisplay: false
            }, 'google_translate_element');
        }
    </script>
    <script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    @stack('scripts')
</body>
</html>
