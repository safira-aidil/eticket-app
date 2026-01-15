<x-app-layout>
    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(Auth::user()->usertype === 'admin')
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="px-3 py-1 bg-indigo-600 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-lg shadow-lg shadow-indigo-200">System Administrator</span>
                        <div class="h-[2px] w-12 bg-indigo-200"></div>
                    </div>
                    <h2 class="text-5xl font-black text-slate-900 tracking-tighter italic uppercase leading-none">
                        Monitoring <span class="text-indigo-600">Panel</span>
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
                    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm transition hover:shadow-xl group">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Total Tiket</p>
                        <h3 class="text-5xl font-black text-slate-900 group-hover:scale-110 transition-transform origin-left">{{ $stats['total'] ?? 0 }}</h3>
                    </div>

                    <div class="bg-indigo-600 p-8 rounded-[2.5rem] shadow-[0_20px_40px_rgba(79,70,229,0.3)] group">
                        <p class="text-[10px] font-black text-indigo-200 uppercase tracking-widest mb-4">Menunggu Respon</p>
                        <h3 class="text-5xl font-black text-white group-hover:scale-110 transition-transform origin-left">{{ $stats['waiting'] ?? 0 }}</h3>
                    </div>

                    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm group">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Dalam Proses</p>
                        <h3 class="text-5xl font-black text-slate-900 group-hover:scale-110 transition-transform origin-left">{{ $stats['process'] ?? 0 }}</h3>
                    </div>

                    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm group">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Resolved</p>
                        <h3 class="text-5xl font-black text-emerald-500 group-hover:scale-110 transition-transform origin-left">{{ $stats['done'] ?? 0 }}</h3>
                    </div>
                </div>

                <div class="bg-white rounded-[3rem] border border-slate-100 shadow-xl overflow-hidden">
                    <div class="px-10 py-8 border-b border-slate-50 bg-slate-50/50 flex justify-between items-center">
                        <h3 class="font-black text-slate-800 uppercase text-sm tracking-widest">Antrean Laporan Masuk</h3>
                        <a href="{{ route('admin.tickets.index') }}" class="px-6 py-2 bg-indigo-50 text-indigo-600 rounded-full text-[10px] font-black uppercase tracking-widest hover:bg-indigo-600 hover:text-white transition">Manajemen Tiket</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <tbody class="divide-y divide-slate-50">
                                @forelse($latestTickets as $ticket)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-10 py-6">
                                        <p class="text-[10px] font-black text-indigo-500 mb-1">#{{ $ticket->ticket_number }}</p>
                                        <p class="font-bold text-slate-800 leading-none">{{ $ticket->user->name ?? 'OPD' }}</p>
                                    </td>
                                    <td class="px-10 py-6 font-bold text-slate-600">{{ $ticket->title }}</td>
                                    <td class="px-10 py-6">
                                        <span class="px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest bg-amber-50 text-amber-600 border border-amber-100">
                                            {{ $ticket->status }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr><td class="p-20 text-center font-bold text-slate-300">Belum ada aktivitas.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            @else
                <div class="bg-indigo-700 rounded-[3rem] p-12 mb-10 relative overflow-hidden shadow-2xl shadow-indigo-200">
                    <div class="relative z-10">
                        <h1 class="text-5xl font-black text-white tracking-tight leading-none mb-6 italic uppercase">
                            Halo, {{ Auth::user()->name }}! 👋
                        </h1>
                        <p class="text-indigo-100 font-bold max-w-md mb-10 text-lg leading-relaxed opacity-90">
                            Ada kendala teknis? Tim IT Diskominfo Binjai siap membantu Anda sekarang.
                        </p>
                        <div class="flex gap-4">
                            <a href="{{ route('tickets.create') }}" class="bg-white text-indigo-700 px-10 py-5 rounded-[2rem] font-black text-sm uppercase tracking-[0.2em] hover:scale-105 transition shadow-xl active:scale-95">
                                Buat Laporan Baru
                            </a>
                        </div>
                    </div>
                    <div class="absolute -right-10 -bottom-10 text-[18rem] opacity-10 rotate-12 select-none">💻</div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Total Tiket Saya</p>
                        <h3 class="text-5xl font-black text-slate-800 leading-none">{{ $stats['total'] ?? 0 }}</h3>
                    </div>
                    <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Sedang Diproses</p>
                        <h3 class="text-5xl font-black text-amber-500 leading-none">{{ $stats['process'] ?? 0 }}</h3>
                    </div>
                    <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Berhasil Selesai</p>
                        <h3 class="text-5xl font-black text-emerald-500 leading-none">{{ $stats['done'] ?? 0 }}</h3>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>