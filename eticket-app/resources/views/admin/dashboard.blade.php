<x-app-layout>
    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-[10px] font-black uppercase tracking-[0.2em] rounded-lg">Admin Central</span>
                        <div class="h-1 w-12 bg-indigo-200 rounded-full"></div>
                    </div>
                    <h2 class="text-4xl font-black text-slate-900 tracking-tighter italic uppercase leading-none">
                        Overview Operasional
                    </h2>
                </div>
                <div class="flex gap-4">
                    <button class="px-6 py-3 bg-white border border-slate-200 text-slate-600 rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-slate-50 transition shadow-sm">
                        Export Laporan
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-[0_15px_30px_-10px_rgba(0,0,0,0.02)]">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Total Masuk</p>
                    <div class="flex items-baseline gap-2">
                        <h3 class="text-5xl font-black text-slate-900 leading-none">{{ $total }}</h3>
                        <span class="text-xs font-bold text-slate-400">Tiket</span>
                    </div>
                </div>

                <div class="bg-indigo-600 p-8 rounded-[2.5rem] shadow-[0_20px_40px_rgba(79,70,229,0.2)]">
                    <p class="text-[10px] font-black text-indigo-200 uppercase tracking-widest mb-4">Menunggu</p>
                    <div class="flex items-baseline gap-2 text-white">
                        <h3 class="text-5xl font-black leading-none">{{ $waiting }}</h3>
                        <span class="text-xs font-bold opacity-80 italic">Urgent</span>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Resolved</p>
                    <div class="flex items-baseline gap-2">
                        <h3 class="text-5xl font-black text-emerald-500 leading-none">{{ $done }}</h3>
                        <span class="text-xs font-bold text-slate-400">Selesai</span>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">User Aktif</p>
                    <div class="flex items-baseline gap-2">
                        <h3 class="text-5xl font-black text-slate-900 leading-none">{{ $totalUser }}</h3>
                        <span class="text-xs font-bold text-slate-400">Instansi</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[3rem] border border-slate-100 shadow-xl shadow-slate-200/50 overflow-hidden">
                <div class="px-10 py-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
                    <div class="flex items-center gap-4">
                        <div class="w-2 h-8 bg-indigo-600 rounded-full"></div>
                        <h3 class="font-black text-slate-800 uppercase text-sm tracking-[0.15em]">Laporan Masuk Real-Time</h3>
                    </div>
                    <a href="{{ route('admin.tickets.index') }}" class="text-[10px] font-black text-indigo-600 uppercase tracking-widest hover:text-indigo-800 transition">Lihat Semua Data →</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50">
                                <th class="px-10 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">OPD / Instansi</th>
                                <th class="px-10 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Judul Kendala</th>
                                <th class="px-10 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Waktu</th>
                                <th class="px-10 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($latestTickets as $ticket)
                            <tr class="hover:bg-indigo-50/30 transition group">
                                <td class="px-10 py-6">
                                    <div class="flex flex-col">
                                        <span class="font-black text-slate-800 tracking-tight leading-none mb-1">{{ $ticket->user->name ?? 'OPD Umum' }}</span>
                                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter italic">ID: #{{ $ticket->ticket_number }}</span>
                                    </div>
                                </td>
                                <td class="px-10 py-6">
                                    <span class="font-bold text-slate-600 group-hover:text-indigo-600 transition">{{ $ticket->title }}</span>
                                </td>
                                <td class="px-10 py-6 text-xs font-bold text-slate-400">
                                    {{ $ticket->created_at->diffForHumans() }}
                                </td>
                                <td class="px-10 py-6 text-right">
                                    <span class="px-4 py-2 bg-slate-100 text-slate-500 rounded-xl text-[9px] font-black uppercase tracking-widest">
                                        {{ $ticket->status }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="p-20 text-center text-slate-300 font-black uppercase tracking-widest">Belum ada aktivitas hari ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>