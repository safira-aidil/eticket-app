<x-app-layout>
    <x-slot name="header">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            .select2-container--default .select2-selection--single {
                background-color: #f8fafc !important;
                border: 2px solid #f1f5f9 !important;
                border-radius: 1.25rem !important;
                height: 64px !important;
                display: flex !important;
                align-items: center !important;
                font-weight: 700 !important;
                color: #1e293b !important;
                padding-left: 1.25rem !important;
                transition: all 0.3s ease !important;
            }
            .select2-container--default.select2-container--focus .select2-selection--single {
                background-color: white !important;
                border-color: #6366f1 !important;
                box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1) !important;
            }
            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 64px !important;
                right: 20px !important;
            }
            .select2-dropdown {
                border-radius: 1.5rem !important;
                border: 1px solid #e2e8f0 !important;
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1) !important;
                padding: 0.5rem !important;
            }
            .form-fade-in { animation: slideUp 0.7s ease-out; }
            @keyframes slideUp {
                from { opacity: 0; transform: translateY(30px); }
                to { opacity: 1; transform: translateY(0); }
            }
        </style>

        <div class="flex items-center justify-center space-x-4">
            <div class="p-3 bg-gradient-to-br from-indigo-600 to-violet-700 rounded-2xl shadow-xl shadow-indigo-200">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </div>
            <div>
                <h2 class="font-black text-3xl text-slate-900 tracking-tight leading-none italic uppercase">
                    {{ __('Form Laporan') }}
                </h2>
                <p class="text-[10px] font-bold text-indigo-500 uppercase tracking-[0.2em] mt-1">E-Ticket Service Center Binjai</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 form-fade-in">
            
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-2xl shadow-sm">
                    <ul class="text-sm text-red-700 font-bold">
                        @foreach ($errors->all() as $error)
                            <li>⚠️ {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow-[0_40px_80px_-15px_rgba(79,70,229,0.1)] rounded-[3rem] overflow-hidden border border-slate-100">
                <div class="h-2 w-full bg-slate-50 flex">
                    <div class="h-full bg-indigo-600 w-1/3 shadow-[0_0_15px_rgba(99,102,241,0.5)]"></div>
                </div>

                <div class="p-10 sm:p-16">
                    <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                        @csrf

                        <div>
                            <label for="title" class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.25em] mb-4 ml-2">Subjek / Unit Kerja</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}"
                                class="w-full px-8 py-5 bg-slate-50 border-2 border-slate-50 rounded-[1.5rem] focus:ring-0 focus:border-indigo-500 focus:bg-white transition-all duration-300 font-bold text-slate-800 placeholder-slate-300 shadow-sm text-lg"
                                placeholder="Misal: Bidang IKP - PC Tidak Bisa Booting" required>
                        </div>

                        <div>
                            <label for="instansi" class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.25em] mb-4 ml-2">Instansi / Perangkat Daerah</label>
                            <select name="instansi" id="instansi" class="w-full" required>
                                <option value=""></option> 
                                <option value="">CARI INSTANSI ANDA...</option>
                                    <option value="Inspektur Kota Binjai">Inspektur Kota Binjai</option>
                                    <option value="Kepala Dinas Pendidikan Kota Binjai">Kepala Dinas Pendidikan Kota Binjai</option>
                                    <option value="Kepala Dinas Kesehatan Kota Binjai">Kepala Dinas Kesehatan Kota Binjai</option>
                                    <option value="Kepala Dinas Pekerjaan Umum dan Tata Ruang Kota Binjai">Kepala Dinas Pekerjaan Umum dan Tata Ruang Kota Binjai</option>
                                    <option value="Kepala Dinas Perumahan dan Kawasan Permukiman Kota Binjai">Kepala Dinas Perumahan dan Kawasan Permukiman Kota Binjai</option>
                                    <option value="Kepala Dinas Sosial Kota Binjai">Kepala Dinas Sosial Kota Binjai</option>
                                    <option value="Kepala Dinas Ketenagakerjaan, Perindustrian dan Perdagangan Kota Binjai">Kepala Dinas Ketenagakerjaan, Perindustrian dan Perdagangan Kota Binjai</option>
                                    <option value="Kepala Dinas Pemberdayaan Perempuan, Perlindungan Anak dan Masyarakat Kota Binjai">Kepala Dinas Pemberdayaan Perempuan, Perlindungan Anak dan Masyarakat Kota Binjai</option>
                                    <option value="Kepala Dinas Ketahanan Pangan dan Pertanian Kota Binjai">Kepala Dinas Ketahanan Pangan dan Pertanian Kota Binjai</option>
                                    <option value="Kepala Dinas Lingkungan Hidup Kota Binjai">Kepala Dinas Lingkungan Hidup Kota Binjai</option>
                                    <option value="Kepala Dinas Kependudukan dan Pencatatan Sipil Kota Binjai">Kepala Dinas Kependudukan dan Pencatatan Sipil Kota Binjai</option>
                                    <option value="Kepala Dinas Pengendalian Penduduk dan KB Kota Binjai">Kepala Dinas Pengendalian Penduduk dan KB Kota Binjai</option>
                                    <option value="Kepala Dinas Perhubungan Kota Binjai">Kepala Dinas Perhubungan Kota Binjai</option>
                                    <option value="Kepala Dinas Komunikasi dan Informatika Kota Binjai">Kepala Dinas Komunikasi dan Informatika Kota Binjai</option>
                                    <option value="Kepala Dinas Koperasi, Usaha Kecil dan Menengah Kota Binjai">Kepala Dinas Koperasi, Usaha Kecil dan Menengah Kota Binjai</option>
                                    <option value="Kepala Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Kota Binjai">Kepala Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Kota Binjai</option>
                                    <option value="Kepala Dinas Pemuda dan Keolahragaan Kota Binjai">Kepala Dinas Pemuda dan Keolahragaan Kota Binjai</option>
                                    <option value="Kepala Dinas Pariwisata Kota Binjai">Kepala Dinas Pariwisata Kota Binjai</option>
                                    <option value="Kepala Dinas Perpustakaan Kota Binjai">Kepala Dinas Perpustakaan Kota Binjai</option>
                                    <option value="Kepala Badan Penanggulangan Bencana Daerah Kota Binjai">Kepala Badan Penanggulangan Bencana Daerah Kota Binjai</option>
                                    <option value="Kepala Badan Perencanaan Pembangunan, Riset dan Inovasi Daerah Kota Binjai">Kepala Badan Perencanaan Pembangunan, Riset dan Inovasi Daerah Kota Binjai</option>
                                    <option value="Kepala Badan Pengelolaan Keuangan dan Pendapatan Daerah Kota Binjai">Kepala Badan Pengelolaan Keuangan dan Pendapatan Daerah Kota Binjai</option>
                                    <option value="Kepala Badan Kepegawaian dan Pengembangan Sumber Daya Manusia Kota Binjai">Kepala Badan Kepegawaian dan Pengembangan Sumber Daya Manusia Kota Binjai</option>
                                    <option value="Kepala Badan Kesatuan Bangsa dan Politik Kota Binjai">Kepala Badan Kesatuan Bangsa dan Politik Kota Binjai</option>
                                    <option value="Kepala Satuan Polisi Pamong Praja (Satpol-PP) Kota Binjai">Kepala Satuan Polisi Pamong Praja (Satpol-PP) Kota Binjai</option>
                                    <option value="Direktur RSUD Dr. R. M. Djoelham Kota Binjai">Direktur RSUD Dr. R. M. Djoelham Kota Binjai</option>
                                    <option value="Sekretaris DPRD Kota Binjai">Sekretaris DPRD Kota Binjai</option>
                                    <option value="Kepala Bagian Pemerintahan Sekretariat Daerah Kota Binjai">Kepala Bagian Pemerintahan Sekretariat Daerah Kota Binjai</option>
                                    <option value="Kepala Bagian Administrasi Pembangunan Sekretariat Daerah Kota Binjai">Kepala Bagian Administrasi Pembangunan Sekretariat Daerah Kota Binjai</option>
                                    <option value="Kepala Bagian Pengadaan Barang dan Jasa Sekretariat Daerah Kota Binjai">Kepala Bagian Pengadaan Barang dan Jasa Sekretariat Daerah Kota Binjai</option>
                                    <option value="Kepala Bagian Protokol dan Komunikasi Pimpinan Daerah Sekretariat Daerah Kota Binjai">Kepala Bagian Protokol dan Komunikasi Pimpinan Daerah Sekretariat Daerah Kota Binjai</option>
                                    <option value="Kepala Bagian Organisasi Sekretariat Daerah Kota Binjai">Kepala Bagian Organisasi Sekretariat Daerah Kota Binjai</option>
                                    <option value="Kepala Bagian Hukum Sekretariat Daerah Kota Binjai">Kepala Bagian Hukum Sekretariat Daerah Kota Binjai</option>
                                    <option value="Kepala Bagian Kesejahteraan Rakyat Sekretariat Daerah Kota Binjai">Kepala Bagian Kesejahteraan Rakyat Sekretariat Daerah Kota Binjai</option>
                                    <option value="Kepala Bagian Umum Sekretariat Daerah Kota Binjai">Kepala Bagian Umum Sekretariat Daerah Kota Binjai</option>
                                    <option value="Kepala Bagian Perekonomian dan Sumber Daya Alam Sekretariat Daerah Kota Binjai">Kepala Bagian Perekonomian dan Sumber Daya Alam Sekretariat Daerah Kota Binjai</option>
                                    <option value="Camat Binjai Utara">Camat Binjai Utara</option>
                                    <option value="Camat Binjai Timur">Camat Binjai Timur</option>
                                    <option value="Camat Binjai Barat">Camat Binjai Barat</option>
                                    <option value="Camat Binjai Kota">Camat Binjai Kota</option>
                                    <option value="Camat Binjai Selatan">Camat Binjai Selatan</option>
                                </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <div>
                                <label for="category" class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.25em] mb-4 ml-2">Kategori Layanan</label>
                                <div class="relative group">
                                    <select name="category" id="category" 
                                        class="w-full px-8 py-5 bg-slate-50 border-2 border-slate-50 rounded-[1.5rem] focus:ring-0 focus:border-indigo-500 focus:bg-white transition-all duration-300 font-bold text-slate-800 appearance-none shadow-sm cursor-pointer text-sm">
                                        <option value="Sistem Informasi">🌐 Aplikasi / Website</option>
                                        <option value="Jaringan">📶 Infrastruktur & Jaringan</option>
                                        <option value="Perangkat Keras">💻 Hardware & PC</option>
                                        <option value="Siber">🛡️ Keamanan Siber</option>
                                        <option value="Lainnya">🧩 Lainnya</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-6 pointer-events-none text-indigo-500 group-hover:translate-y-0.5 transition-transform">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.25em] mb-4 ml-2">Lampiran Bukti (Foto)</label>
                                <div class="relative group h-[64px]">
                                    <input type="file" name="image" id="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                                    <div class="w-full h-full px-6 bg-indigo-50/50 border-2 border-dashed border-indigo-200 rounded-[1.5rem] group-hover:bg-indigo-600 group-hover:border-indigo-600 transition-all duration-500 flex items-center justify-center space-x-3">
                                        <svg class="w-6 h-6 text-indigo-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span id="file-label" class="text-xs font-black text-indigo-700 uppercase tracking-widest group-hover:text-white transition-colors">Pilih File Foto</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="description" class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.25em] mb-4 ml-2">Deskripsi Detail Keluhan</label>
                            <textarea name="description" id="description" rows="5" 
                                class="w-full px-8 py-6 bg-slate-50 border-2 border-slate-50 rounded-[2rem] focus:ring-0 focus:border-indigo-500 focus:bg-white transition-all duration-300 font-bold text-slate-800 placeholder-slate-300 shadow-sm"
                                placeholder="Jelaskan secara rinci permasalahan teknis yang Anda alami..." required>{{ old('description') }}</textarea>
                        </div>

                        <div class="pt-6">
                            <button type="submit" 
                                class="w-full py-6 bg-indigo-700 hover:bg-indigo-800 text-white rounded-[2rem] font-black text-sm uppercase tracking-[0.4em] shadow-[0_20px_40px_rgba(79,70,229,0.3)] hover:shadow-indigo-300 transition-all duration-500 transform hover:-translate-y-1 active:scale-95 flex items-center justify-center space-x-3 group">
                                <span>Kirim Laporan</span>
                                <svg class="w-5 h-5 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7-7 7"></path></svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Select2 menggunakan ID instansi
            $('#instansi').select2({
                placeholder: "CARI INSTANSI ANDA...",
                allowClear: true
            });

            // File Upload Listener
            document.getElementById('image').onchange = function () {
                if(this.files.length > 0) {
                    let fileName = this.files[0].name;
                    let fileLabel = document.getElementById('file-label');
                    fileLabel.innerHTML = "✅ " + fileName;
                    fileLabel.classList.remove('text-indigo-700');
                    fileLabel.classList.add('text-emerald-600');
                }
            };
        });
    </script>
</x-app-layout>