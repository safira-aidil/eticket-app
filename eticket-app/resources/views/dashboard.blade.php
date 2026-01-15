<x-app-layout>
    <div class="py-12 bg-[#f8fafc] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- 1️⃣ CEK ROLE ADMIN --}}
            @if(Auth::user()->role === 'admin')
                
                <div class="mb-10 flex justify-between items-end">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <span class="px-3 py-1 bg-indigo-600 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-lg shadow-lg">System Administrator</span>
                        </div>
                        <h2 class="text-5xl font-black text-slate-900 tracking-tighter italic uppercase leading-none">
                            Monitoring <span class="text-indigo-600">Panel</span>
                        </h2>
                    </div>
                    {{-- 5️⃣ Sistem Notifikasi Ringan --}}
                    <div class="hidden md:flex items-center gap-3 bg-white p-3 rounded-2xl border border-slate-100 shadow-sm">
                        <div class="h-10 w-10 bg-rose-50 rounded-xl flex items-center justify-center text-xl animate-pulse">🔔</div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase leading-none">Pemberitahuan</p>
                            <p class="text-[11px] font-bold text-slate-700 mt-1">{{ $stats['waiting'] ?? 0 }} tiket baru perlu dicek.</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
                    <div class="bg-blue-50/50 p-5 rounded-3xl border border-blue-100 flex items-center gap-4 hover:bg-white transition shadow-sm">
                        <span class="text-2xl">🎫</span>
                        <div>
                            <p class="text-[9px] font-black text-blue-400 uppercase leading-none">Hari Ini</p>
                            <p class="text-xl font-black text-slate-800 mt-1">{{ $todayCount ?? 0 }}</p>
                        </div>
                    </div>
                    <div class="bg-rose-50/50 p-5 rounded-3xl border border-rose-100 flex items-center gap-4 hover:bg-white transition shadow-sm">
                        <span class="text-2xl">🔴</span>
                        <div>
                            <p class="text-[9px] font-black text-rose-400 uppercase leading-none">Mendesak</p>
                            <p class="text-xl font-black text-slate-800 mt-1">{{ $urgentCount ?? 0 }}</p>
                        </div>
                    </div>
                    <div class="bg-amber-50/50 p-5 rounded-3xl border border-amber-100 flex items-center gap-4 hover:bg-white transition shadow-sm">
                        <span class="text-2xl">⏳</span>
                        <div>
                            <p class="text-[9px] font-black text-amber-400 uppercase leading-none">Pending</p>
                            <p class="text-xl font-black text-slate-800 mt-1">{{ $stats['waiting'] ?? 0 }}</p>
                        </div>
                    </div>
                    <div class="bg-emerald-50/50 p-5 rounded-3xl border border-emerald-100 flex items-center gap-4 hover:bg-white transition shadow-sm">
                        <span class="text-2xl">⏱️</span>
                        <div>
                            <p class="text-[9px] font-black text-emerald-400 uppercase leading-none">Waktu Respon</p>
                            <p class="text-xl font-black text-slate-800 mt-1">10m</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 bg-white rounded-[2.5rem] border border-slate-100 shadow-xl overflow-hidden">
                        <div class="px-10 py-8 border-b border-slate-50 flex justify-between items-center">
                            <h3 class="font-black text-slate-800 uppercase text-xs tracking-widest italic">Aktivitas Terkini</h3>
                            <a href="{{ route('admin.tickets.index') }}" class="text-[10px] font-black text-indigo-600 uppercase border-b-2 border-indigo-600">Lihat Semua</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <tbody class="divide-y divide-slate-50">
                                    @forelse($latestTickets as $ticket)
                                    <tr class="hover:bg-slate-50 transition group">
                                        <td class="px-10 py-6">
                                            <p class="font-bold text-slate-800 text-sm leading-none">{{ $ticket->user->name ?? 'User' }}</p>
                                            <p class="text-[9px] font-black text-slate-400 uppercase mt-1 italic">{{ $ticket->created_at->diffForHumans() }}</p>
                                        </td>
                                        <td class="px-10 py-6 font-bold text-slate-600 text-sm italic">{{ $ticket->title }}</td>
                                        <td class="px-10 py-6">
                                            @php
                                                $color = $ticket->status == 'waiting' ? 'rose' : ($ticket->status == 'process' ? 'amber' : 'emerald');
                                            @endphp
                                            <span class="px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest bg-{{$color}}-50 text-{{$color}}-600 border border-{{$color}}-100">
                                                {{ $ticket->status }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    {{-- 6️⃣ Keadaan Kosong --}}
                                    <tr>
                                        <td class="p-20 text-center">
                                            <div class="opacity-20 flex flex-col items-center">
                                                <span class="text-7xl mb-4 italic">📁</span>
                                                <p class="font-black uppercase tracking-[0.3em] text-slate-400">Belum ada tiket masuk</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="space-y-8">
                        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Aksi Cepat</p>
                            <div class="grid grid-cols-2 gap-4">
                                <a href="{{ route('tickets.create') }}" class="flex flex-col items-center p-5 bg-slate-50 rounded-3xl hover:bg-indigo-600 hover:text-white transition group border border-slate-100">
                                    <span class="text-2xl mb-2 group-hover:scale-110 transition-transform">➕</span>
                                    <span class="text-[9px] font-black uppercase">Tambah</span>
                                </a>
                                <a href="#" class="flex flex-col items-center p-5 bg-slate-50 rounded-3xl hover:bg-indigo-600 hover:text-white transition group border border-slate-100">
                                    <span class="text-2xl mb-2 group-hover:scale-110 transition-transform">📄</span>
                                    <span class="text-[9px] font-black uppercase">Laporan</span>
                                </a>
                            </div>
                        </div>

                        <div class="bg-slate-900 p-8 rounded-[3rem] text-white shadow-2xl relative overflow-hidden">
                            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-8">Statistik Status</p>
                            <div class="flex items-end justify-between h-20 gap-2">
                                <div class="w-full bg-rose-500 rounded-t-lg h-[40%]" title="Waiting"></div>
                                <div class="w-full bg-amber-500 rounded-t-lg h-[65%]" title="Process"></div>
                                <div class="w-full bg-emerald-500 rounded-t-lg h-[100%]" title="Done"></div>
                            </div>
                            <div class="mt-4 flex justify-between text-[8px] font-black text-slate-600 uppercase">
                                <span>Wait</span><span>Proc</span><span>Done</span>
                            </div>
                            <div class="absolute -right-6 -bottom-6 text-8xl opacity-5 rotate-12">📊</div>
                        </div>
                    </div>
                </div>

            @else
                <div class="bg-indigo-700 rounded-[3rem] p-12 mb-10 relative overflow-hidden shadow-2xl">
                    <div class="relative z-10">
                        <h1 class="text-5xl font-black text-white tracking-tight leading-none mb-6 italic uppercase">
                            Halo, {{ Auth::user()->name }}! 👋
                        </h1>
                        <p class="text-indigo-100 font-bold max-w-md mb-10 text-lg leading-relaxed opacity-90 italic">
                            Ada kendala teknis? Tim IT Diskominfo Binjai siap membantu Anda sekarang.
                        </p>
                        <a href="{{ route('tickets.create') }}" class="bg-white text-indigo-700 px-10 py-5 rounded-[2rem] font-black text-sm uppercase tracking-[0.2em] hover:scale-105 transition shadow-xl active:scale-95">
                            Buat Laporan Baru
                        </a>
                    </div>
                    <div class="absolute -right-10 -bottom-10 text-[18rem] opacity-10 rotate-12 select-none">💻</div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Tiket Saya</p>
                        <h3 class="text-5xl font-black text-slate-800 leading-none">{{ $stats['total'] ?? 0 }}</h3>
                    </div>
                    <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Proses</p>
                        <h3 class="text-5xl font-black text-amber-500 leading-none">{{ $stats['process'] ?? 0 }}</h3>
                    </div>
                    <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Selesai</p>
                        <h3 class="text-5xl font-black text-emerald-500 leading-none">{{ $stats['done'] ?? 0 }}</h3>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>