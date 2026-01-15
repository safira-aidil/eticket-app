<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>E-Ticket Binjai | DISKOMINFO Premium</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --diskominfo-navy: #002455;
            --diskominfo-blue: #00569c;
            --diskominfo-orange: #f39200;
            --sidebar-width: 380px;
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #fcfcfc;
            margin: 0;
            overflow-x: hidden;
        }

        /* --- SIDEBAR JUMBO --- */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: #ffffff;
            position: fixed;
            left: calc(var(--sidebar-width) * -1);
            top: 0;
            z-index: 1000;
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            border-right: 1px solid #f1f5f9;
            box-shadow: 25px 0 50px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
        }

        .sidebar.open {
            left: 0;
        }

        /* --- OVERLAY BLUR --- */
        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 36, 85, 0.2);
            backdrop-filter: blur(8px);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s ease;
        }

        .sidebar-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        /* --- NAV LINKS --- */
        .nav-link {
            display: flex;
            align-items: center;
            gap: 25px;
            padding: 22px 35px;
            margin: 8px 15px;
            border-radius: 0 50px 50px 0;
            color: #5f6368;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background-color: #f8fafc;
            color: var(--diskominfo-blue);
        }

        .nav-link.active {
            background-color: #eef2ff;
            color: var(--diskominfo-blue);
            box-shadow: inset 8px 0 0 var(--diskominfo-blue);
        }

        /* --- HEADER --- */
        .top-header {
            height: 90px;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            padding: 0 40px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #f1f5f9;
            position: sticky;
            top: 0;
            z-index: 50;
            gap: 20px;
        }

        .hamburger-container {
            width: 55px;
            height: 55px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            cursor: pointer;
            transition: 0.3s;
        }

        .hamburger-container:hover {
            background-color: #f1f3f4;
        }
    </style>
</head>
<body>

    <div id="overlay" class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <aside id="sidebar" class="sidebar">
        <div class="p-10 mb-6 flex flex-col gap-6 items-center">
            <img src="{{ asset('images/kominfo.png') }}?v={{ time() }}" alt="DISKOMINFO" class="w-64 h-auto object-contain">
            <div class="h-[1px] w-full bg-slate-100"></div>
        </div>

        <nav class="flex-1">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <span class="text-3xl">📊</span>
                <span>Beranda Utama</span>
            </a>
            <a href="{{ route('tickets.index') }}" class="nav-link {{ request()->routeIs('tickets.index') ? 'active' : '' }}">
                <span class="text-3xl">🎫</span>
                <span>Manajemen Tiket</span>
            </a>
            <a href="{{ route('tickets.create') }}" class="nav-link {{ request()->routeIs('tickets.create') ? 'active' : '' }}">
                <span class="text-3xl">✍️</span>
                <span>Buat Laporan</span>
            </a>
        </nav>

        <div class="p-10">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full py-5 bg-rose-50 text-rose-600 rounded-2xl font-bold hover:bg-rose-600 hover:text-white transition-all">
                    LOGOUT SYSTEM
                </button>
            </form>
        </div>
    </aside>

    <div class="main-wrapper">
        <header class="top-header">
            <div class="hamburger-container" onclick="toggleSidebar()">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </div>

            <div class="flex items-center gap-4">
                <img src="{{ asset('images/kominfo.png') }}?v={{ time() }}" alt="Logo" class="h-10 w-auto">
                <div class="h-8 w-[1px] bg-slate-200"></div>
                <h2 class="text-2xl font-bold text-slate-800 tracking-tighter">E-Ticket <span class="text-blue-600">Binjai</span></h2>
            </div>

            <div class="ml-auto flex items-center gap-6">
                <div class="text-right hidden md:block">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">User Aktif</p>
                    <p class="font-bold text-slate-700">{{ Auth::user()->name }}</p>
                </div>
                <div class="w-14 h-14 bg-blue-600 rounded-2xl flex items-center justify-center text-white text-xl font-bold shadow-lg">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            </div>
        </header>

        <main class="px-20 py-16">
            <div class="max-w-7xl mx-auto">
                <div class="mb-14 border-l-8 border-blue-600 pl-8">
                    <h3 class="text-6xl font-black text-slate-900 tracking-tighter uppercase italic leading-none">
                        {{ $header ?? 'Beranda' }}
                    </h3>
                    <p class="text-xl font-medium text-slate-400 mt-2">Pusat Layanan Terpadu DISKOMINFO Kota Binjai.</p>
                </div>

                {{ $slot }}
            </div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
        }
    </script>
</body>
</html>