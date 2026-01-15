<x-guest-layout>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* 1. Global Reset */
        body, html {
            margin: 0;
            padding: 0;
            background-color: #001a3d !important;
        }

        .min-h-screen {
            background-color: #001a3d !important; 
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 20px !important;
        }

        .min-h-screen > div:first-child > a { display: none !important; }

        .min-h-screen > div {
            background: transparent !important;
            box-shadow: none !important;
            width: 100% !important;
            max-width: 1300px !important;
            display: flex !important;
            justify-content: center !important;
        }

        /* 2. Kartu Utama */
        .ultra-card {
            display: grid;
            grid-template-columns: 42% 58%;
            width: 100%;
            height: 700px; 
            background: white;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.7);
        }

        /* 3. Sisi Kiri (Branding) - Dibuat Center secara Vertikal */
        .side-branding {
            background: #002455;
            padding: 60px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center; /* Membuat tulisan "Sistem Tiket" pas di tengah */
            position: relative; /* Diperlukan untuk posisi logo & footer */
        }

        /* Logo & Teks Diskominfo (Diletakkan di atas) */
        .brand-header {
            position: absolute;
            top: 50px;
            left: 60px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-container {
            background: white;
            width: 70px;
            height: 70px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 15px rgba(0,0,0,0.2);
        }

        .logo-container img {
            width: 50px;
            height: auto;
        }

        .brand-text { display: flex; flex-direction: column; }
        .brand-text .main-text { font-size: 1.4rem; font-weight: 800; letter-spacing: 1.5px; line-height: 1; margin-bottom: 4px; color: white; }
        .brand-text .separator { width: 100%; height: 2px; background: #ff6b35; margin-bottom: 4px; }
        .brand-text .sub-text { font-size: 0.8rem; font-weight: 600; color: rgba(255,255,255,0.7); text-transform: uppercase; }

        /* Area Judul (Pusat Perhatian) */
        .title-area h1 {
            font-size: 3.2rem;
            font-weight: 800;
            line-height: 1.1;
            margin: 0 0 20px 0;
        }

        .title-area h1 span { color: #ff6b35; }

        .desc-area {
            font-size: 1.1rem;
            color: rgba(255,255,255,0.7);
            border-left: 5px solid #ff6b35;
            padding-left: 20px;
            max-width: 90%;
        }

        /* Footer Info (Diletakkan di bawah) */
        .footer-branding {
            position: absolute;
            bottom: 50px;
            left: 60px;
            display: flex;
            align-items: center;
            gap: 12px;
            opacity: 0.6;
        }

        /* 4. Sisi Kanan (Form Login) */
        .side-login {
            padding: 60px 80px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: white;
        }

        .form-title { font-size: 2.6rem; font-weight: 800; color: #001a3d; margin-bottom: 8px; }

        .input-group { margin-bottom: 22px; }

        .input-group label {
            display: block;
            font-weight: 700;
            color: #64748b;
            font-size: 0.85rem;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .custom-input {
            width: 100%;
            padding: 16px;
            background: #f1f5f9;
            border: 2px solid transparent;
            border-radius: 12px;
            font-size: 1rem;
            transition: 0.3s;
        }

        .custom-input:focus { border-color: #001a3d; background: white; outline: none; }

        .btn-portal {
            width: 100%;
            padding: 18px;
            background: #001a3d;
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 800;
            font-size: 1.1rem;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-portal:hover { background: #ff6b35; transform: translateY(-2px); box-shadow: 0 10px 20px rgba(255, 107, 53, 0.3); }

        @media (max-width: 1024px) {
            .ultra-card { grid-template-columns: 1fr; height: auto; }
            .side-branding { display: none; }
        }
    </style>

    <div class="ultra-card">
        <div class="side-branding">
            <div class="brand-header">
                <div class="logo-container">
                    <img src="{{ asset('images/kominfo.png') }}" alt="Logo Kominfo">
                </div>
                <div class="brand-text">
                    <span class="main-text">DISKOMINFO</span>
                    <div class="separator"></div>
                    <span class="sub-text">KOTA BINJAI</span>
                </div>
            </div>
            
            <div class="title-area">
                <h1>Sistem Tiket<br><span>Elektronik</span></h1>
                <p class="desc-area">Portal manajemen layanan bantuan teknologi informasi Pemerintah Kota Binjai.</p>
            </div>

            <div class="footer-branding">
                <div style="background: #ff6b35; width: 35px; height: 35px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 900; color: white;">B</div>
                <div style="font-size: 0.75rem; font-weight: 700;">PEMKOT BINJAI</div>
            </div>
        </div>

        <div class="side-login">
            <h2 class="form-title">Selamat Datang</h2>
            <p style="color: #64748b; margin-bottom: 35px;">Silakan masuk untuk melanjutkan.</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="input-group">
                    <label>Alamat Email</label>
                    <input type="email" name="email" class="custom-input" placeholder="admin@binjaikota.go.id" required autofocus>
                </div>

                <div class="input-group">
                    <div style="display: flex; justify-content: space-between;">
                        <label>Kata Sandi</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" style="font-size: 0.8rem; color: #ff6b35; text-decoration: none; font-weight: 700;">Lupa Sandi?</a>
                        @endif
                    </div>
                    <input type="password" name="password" class="custom-input" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn-portal">Masuk ke Portal →</button>
            </form>

            <p style="text-align: center; margin-top: 40px; color: #64748b; font-size: 0.9rem;">
                Belum memiliki akun? <a href="{{ route('register') }}" style="color: #ff6b35; font-weight: 800; text-decoration: none;">Daftar Sekarang</a>
            </p>
        </div>
    </div>
</x-guest-layout>