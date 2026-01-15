<x-app-layout>
    <style>
        /* Container Zoom & Animation */
        .zoom-container {
            transform: scale(1.01);
            transform-origin: top left;
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Card Style */
        .main-card {
            background: white;
            border-radius: 32px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.03);
            border: 1px solid #f1f5f9;
            overflow: hidden;
        }

        /* Status Badges Premium */
        .badge-waiting { background: #fffbeb; color: #9a3412; border: 1px solid #fef3c7; }
        .badge-process { background: #eff6ff; color: #1e40af; border: 1px solid #dbeafe; }
        .badge-success { background: #f0fdf4; color: #166534; border: 1px solid #dcfce7; }
    </style>

    <div class="zoom-container py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
                <div>
                    <h2 class="text-4xl font-black text-slate-900 tracking-tighter italic uppercase leading-none mb-2">
                        {{ __('Daftar Laporan') }}
                    </h2>
                    <p class="text-slate-400 font-bold text-sm tracking-tight">Manajemen dan pemantauan status tiket secara real-time.</p>
                </div>
                
                <a href="{{ route('tickets.create') }}" class="flex items-center gap-3 px-8 py-4 bg-indigo-600 text-white rounded-2xl font-black text-xs uppercase tracking-[0.15em] hover:bg-indigo-700 hover:shadow-xl hover:shadow-indigo-200 transition-all active:scale-95">
                    <span>➕</span> Buat Laporan Baru
                </a>
            </div>

            <div class="main-card">
                <div class="px-8 py-6 bg-slate-50/50 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Data Monitoring Tiket</h3>
                    <div class="flex gap-2">
                        <div class="w-2 h-2 rounded-full bg-amber-400"></div>
                        <div class="w-2 h-2 rounded-full bg-blue-400"></div>
                        <div class="w-2 h-2 rounded-full bg-emerald-400"></div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-separate border-spacing-0">
                        <thead>
                            <tr>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Info Tiket</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Kategori</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50 text-center">Lampiran</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Status</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($tickets as $ticket)
                            <tr class="hover:bg-slate-50/80 transition-all group">
                                <td class="px-8 py-6">
                                    <div class="flex flex-col">
                                        <span class="text-[10px] font-black text-indigo-500 tracking-widest mb-1 uppercase">#{{ $ticket->ticket_number }}</span>
                                        <span class="font-bold text-slate-800 text-base tracking-tight group-hover:text-indigo-600 transition-colors">{{ $ticket->title }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-2">
                                        <div class="w-1.5 h-1.5 bg-slate-300 rounded-full"></div>
                                        <span class="font-bold text-slate-500 text-xs uppercase tracking-tighter">{{ $ticket->category }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex justify-center">
                                        @if($ticket->image)
                                            <a href="{{ asset('storage/' . $ticket->image) }}" target="_blank" class="block group/img">
                                                <img src="{{ asset('storage/' . $ticket->image) }}" class="w-14 h-14 object-cover rounded-2xl shadow-sm border-2 border-white group-hover/img:scale-110 group-hover/img:shadow-lg transition-all duration-300">
                                            </a>
                                        @else
                                            <div class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center border border-dashed border-slate-200">
                                                <span class="text-[18px]">📷</span>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    @php
                                        // Normalisasi status agar tidak error jika database pakai huruf besar/kecil berbeda
                                        $status = strtolower($ticket->status);
                                        $statusClass = 'badge-waiting';
                                        
                                        if($status == 'processing' || $status == 'diproses') $statusClass = 'badge-process';
                                        if($status == 'success' || $status == 'selesai') $statusClass = 'badge-success';
                                    @endphp
                                    <span class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest {{ $statusClass }}">
                                        {{ $ticket->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <a href="#" class="inline-flex items-center justify-center w-10 h-10 bg-white border border-slate-200 text-slate-400 rounded-xl hover:bg-indigo-600 hover:text-white hover:border-indigo-600 transition-all shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-8 py-24 text-center">
                                    <div class="flex flex-col items-center">
                                        <span class="text-6xl mb-4">📭</span>
                                        <p class="text-slate-400 font-black uppercase tracking-[0.2em] text-sm">Belum ada laporan yang terdaftar.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Bagian ini hanya akan muncul jika kamu menggunakan ->paginate() di Controller --}}
                @if(method_exists($tickets, 'hasPages') && $tickets->hasPages())
                <div class="px-8 py-6 bg-slate-50/30 border-t border-slate-100">
                    {{ $tickets->links() }}
                </div>
                @endif
            </div>

            <div class="mt-8 flex items-center justify-center gap-2">
                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Secure System Encrypted by Diskominfo Binjai</p>
            </div>
        </div>
    </div>
</x-app-layout>