<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>E-Ticket Binjai | DISKOMINFO Premium</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --diskominfo-navy: #002455;
            --diskominfo-blue: #00569c;
            --sidebar-width: 320px;
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #f8fafc;
            margin: 0;
            overflow-x: hidden;
        }

        /* --- ANTI-BLUR & CLEAN RENDER --- */
        * {
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
            filter: none !important;
        }

        /* --- SIDEBAR CONFIG --- */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: #ffffff;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            border-right: 1px solid #e2e8f0;
            display: flex;
            flex-direction: column;
        }

        .sidebar.hidden {
            transform: translateX(-100%);
        }

        /* --- MAIN CONTENT ADJUSTMENT --- */
        .main-wrapper {
            transition: margin-left 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        .main-wrapper.full-width {
            margin-left: 0;
        }

        /* --- NAV LINKS --- */
        .nav-link {
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 14px 24px;
            margin: 4px 16px;
            border-radius: 12px;
            color: #64748b;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.2s ease;
            position: relative;
        }

        .nav-link:hover {
            background-color: #f1f5f9;
            color: var(--diskominfo-blue);
        }

        .nav-link.active {
            background-color: #eff6ff;
            color: var(--diskominfo-blue);
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 25%;
            height: 50%;
            width: 4px;
            background: var(--diskominfo-blue);
            border-radius: 0 4px 4px 0;
        }

        .badge {
            background: #ef4444;
            color: white;
            font-size: 10px;
            padding: 2px 8px;
            border-radius: 20px;
            margin-left: auto;
            font-weight: 800;
        }

        /* --- TOP HEADER --- */
        .top-header {
            height: 80px;
            background: rgba(255, 255, 255, 0.9);
            padding: 0 32px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .hamburger-btn {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.2s;
            border: 1px solid #e2e8f0;
            background: white;
            margin-right: 20px;
        }

        /* --- RESPONSIVE --- */
        @media (max-width: 1024px) {
            .main-wrapper { margin-left: 0 !important; }
            .sidebar-overlay {
                position: fixed; inset: 0;
                background: rgba(0, 0, 0, 0.4);
                z-index: 999; display: none;
            }
            .sidebar-overlay.show { display: block; }
        }
    </style>
</head>
<body>

    <div id="overlay" class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <aside id="sidebar" class="sidebar">
        <div class="p-8 mb-4 flex flex-col items-center">
            <img src="{{ asset('images/kominfo.png') }}" alt="DISKOMINFO" class="w-48 h-auto mb-4">
            <div class="h-[1px] w-full bg-slate-100"></div>
        </div>

        <nav class="flex-1 overflow-y-auto">
            <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                <span class="text-xl">📊</span>
                <span>Beranda Utama</span>
            </a>

            {{-- CEK APAKAH YANG LOGIN ADALAH ADMIN --}}
            @if(Auth::user()->role == 'admin')
                <div class="px-8 mt-6 mb-2">
                    <p class="text-[10px] font-bold text-red-500 uppercase tracking-widest">Panel Administrator</p>
                </div>
                <a href="/tickets" class="nav-link {{ request()->is('tickets') ? 'active' : '' }}">
                    <span class="text-xl">🎫</span>
                    <span>Semua Tiket Masuk</span>
                    {{-- Perbaikan: Angka menjadi otomatis sesuai jumlah database --}}
                    <span class="badge animate-pulse">
                        {{ \App\Models\Ticket::count() }}
                    </span>
                </a>
            @endif

            {{-- CEK APAKAH YANG LOGIN ADALAH USER BIASA --}}
            @if(Auth::user()->role == 'user')
                <div class="px-8 mt-6 mb-2">
                    <p class="text-[10px] font-bold text-blue-500 uppercase tracking-widest">Menu Pengguna</p>
                </div>
                <a href="/tickets/create" class="nav-link {{ request()->is('tickets/create') ? 'active' : '' }}">
                    <span class="text-xl">✍️</span>
                    <span>Buat Laporan Baru</span>
                </a>
                <a href="/my-tickets" class="nav-link {{ request()->is('my-tickets') ? 'active' : '' }}">
                    <span class="text-xl">📋</span>
                    <span>Status Tiket Saya</span>
                </a>
            @endif
        </nav>

        <div class="p-6 border-t border-slate-100">
            <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                @csrf
                <button type="button" onclick="confirmLogout()" class="w-full py-4 bg-rose-50 text-rose-600 rounded-xl font-bold hover:bg-rose-600 hover:text-white transition-all flex items-center justify-center gap-2">
                    <span>🚪</span> LOGOUT SYSTEM
                </button>
            </form>
        </div>
    </aside>

    <div id="mainWrapper" class="main-wrapper">
        <header class="top-header">
            <button class="hamburger-btn" onclick="toggleSidebar()">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>

            <div class="flex items-center gap-3">
                <h2 class="text-xl font-bold text-slate-800 tracking-tight">E-Ticket <span class="text-blue-600">Binjai</span></h2>
            </div>

            <div class="ml-auto flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="text-[9px] font-black {{ Auth::user()->role == 'admin' ? 'text-red-500' : 'text-slate-400' }} uppercase tracking-tighter">
                        {{ Auth::user()->role == 'admin' ? 'Administrator' : 'Operator Aktif' }}
                    </p>
                    <p class="font-bold text-slate-700 text-sm leading-none">{{ Auth::user()->name }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            </div>
        </header>

        <main class="p-6 md:p-12">
            <div class="max-w-6xl mx-auto">
                <div class="mb-10 border-l-4 border-blue-600 pl-6">
                    <h3 class="text-4xl font-extrabold text-slate-900 tracking-tight leading-none uppercase italic">
                        {{ $header ?? 'Beranda' }}
                    </h3>
                    <p class="text-slate-500 mt-2 font-medium">Pusat Layanan Terpadu DISKOMINFO Kota Binjai.</p>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-200/60 min-h-[400px]">
                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainWrapper = document.getElementById('mainWrapper');
            const overlay = document.getElementById('overlay');
            
            sidebar.classList.toggle('hidden');
            mainWrapper.classList.toggle('full-width');
            
            if (window.innerWidth <= 1024) {
                overlay.classList.toggle('show');
            }
        }

        function confirmLogout() {
            if (confirm('Apakah Anda yakin ingin keluar dari sistem?')) {
                document.getElementById('logoutForm').submit();
            }
        }

        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'b') {
                e.preventDefault();
                toggleSidebar();
            }
        });
    </script>
</body>
</html>