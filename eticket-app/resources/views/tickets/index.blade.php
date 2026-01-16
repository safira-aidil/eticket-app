<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <h2 class="font-extrabold text-2xl text-gray-900 leading-tight italic uppercase tracking-tighter">
                    {{ __('Manajemen Laporan Admin') }}
                </h2>
                <p class="text-[10px] font-bold text-indigo-500 uppercase tracking-[0.2em] mt-1">E-Ticket Service Center Binjai</p>
            </div>
            
            <div class="flex gap-2">
                <div class="px-4 py-2 bg-indigo-50 text-indigo-700 rounded-xl text-[10px] font-black uppercase border border-indigo-100 shadow-sm">
                    Total: {{ $tickets->count() }}
                </div>
                <div class="px-4 py-2 bg-amber-50 text-amber-600 rounded-xl text-[10px] font-black uppercase border border-amber-100 shadow-sm">
                    Pending: {{ $tickets->where('status', 'waiting')->count() }}
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-500 text-white rounded-2xl shadow-lg font-bold text-sm flex items-center gap-3 animate-pulse">
                    <span>✅</span> {{ session('success') }}
                </div>
            @endif

            <div class="mb-8 flex flex-col md:flex-row justify-between items-end md:items-center gap-4 bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100">
                <div>
                    <h3 class="font-black text-slate-800 uppercase tracking-tight text-sm mb-1">Daftar Pelayanan Tiket</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Urutkan dan filter laporan sesuai kebutuhan</p>
                </div>

                <form action="{{ route('admin.tickets.index') }}" method="GET" id="filterForm" class="flex flex-wrap gap-3">
                    <div class="relative">
                        <select name="sort" onchange="this.form.submit()" 
                            class="appearance-none bg-slate-50 border-2 border-slate-50 text-slate-700 text-[11px] font-black rounded-xl px-5 py-3 pr-10 focus:border-indigo-500 focus:bg-white focus:ring-0 cursor-pointer transition-all uppercase tracking-widest">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>🕒 Terbaru</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>⏳ Terlama</option>
                        </select>
                    </div>

                    <div class="relative">
                        <select name="status" onchange="this.form.submit()" 
                            class="appearance-none bg-slate-50 border-2 border-slate-50 text-slate-700 text-[11px] font-black rounded-xl px-5 py-3 pr-10 focus:border-indigo-500 focus:bg-white focus:ring-0 cursor-pointer transition-all uppercase tracking-widest">
                            <option value="">📂 Semua Status</option>
                            <option value="waiting" {{ request('status') == 'waiting' ? 'selected' : '' }}>Waiting</option>
                            <option value="process" {{ request('status') == 'process' ? 'selected' : '' }}>Process</option>
                            <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Done</option>
                        </select>
                    </div>
                </form>
            </div>

            <div class="bg-white shadow-xl rounded-[2.5rem] overflow-hidden border border-gray-100">
                <table class="w-full text-left border-separate border-spacing-0">
                    <thead>
                        <tr class="bg-gray-50/50">
                            <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Laporan & Pengirim</th>
                            <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Waktu Masuk</th>
                            <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Lampiran</th>
                            <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Update Status</th>
                            <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($tickets as $ticket)
                        <tr class="hover:bg-indigo-50/20 transition group">
                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="text-[10px] text-indigo-500 font-black mb-1 uppercase tracking-widest">
                                        #{{ $ticket->ticket_number }}
                                    </span>
                                    <p class="font-black text-slate-800 text-sm group-hover:text-indigo-600 transition mb-1 uppercase">
                                        {{ $ticket->title }}
                                    </p>
                                    <div class="flex items-center gap-2">
                                        <div class="w-4 h-4 rounded-full bg-slate-200 flex items-center justify-center text-[8px] font-bold">👤</div>
                                        <span class="text-[10px] font-bold text-slate-500 uppercase">{{ $ticket->user->name ?? 'Anonim' }}</span>
                                    </div>
                                </div>
                            </td>

                            <td class="px-8 py-6 text-center">
                                <div class="flex flex-col items-center">
                                    <span class="text-xs font-bold text-slate-700">{{ $ticket->created_at->translatedFormat('d M Y') }}</span>
                                    <span class="text-[10px] font-black text-indigo-400 uppercase">{{ $ticket->created_at->format('H:i') }} WIB</span>
                                </div>
                            </td>

                            <td class="px-8 py-6">
                                <div class="flex justify-center">
                                    @if($ticket->image)
                                        <a href="{{ asset('storage/' . $ticket->image) }}" target="_blank" class="relative group/img">
                                            <img src="{{ asset('storage/' . $ticket->image) }}" class="w-12 h-12 object-cover rounded-2xl shadow-md border-2 border-white ring-1 ring-slate-100 group-hover/img:scale-110 transition duration-300">
                                            <div class="absolute inset-0 bg-indigo-600/20 rounded-2xl opacity-0 group-hover/img:opacity-100 transition-opacity flex items-center justify-center text-white text-[8px] font-black uppercase">Lihat</div>
                                        </a>
                                    @else
                                        <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center border-2 border-dashed border-slate-100">
                                            <span class="text-slate-300 text-[8px] uppercase font-black">Polos</span>
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <td class="px-8 py-6">
                                <form action="{{ route('tickets.updateStatus', $ticket->id) }}" method="POST" class="flex items-center justify-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="text-[10px] font-black border-2 border-slate-100 rounded-xl bg-slate-50 focus:ring-0 focus:border-indigo-500 uppercase tracking-tighter cursor-pointer">
                                        <option value="waiting" {{ $ticket->status == 'waiting' ? 'selected' : '' }}>🕒 WAITING</option>
                                        <option value="process" {{ $ticket->status == 'process' ? 'selected' : '' }}>⚙️ PROCESS</option>
                                        <option value="done" {{ $ticket->status == 'done' ? 'selected' : '' }}>✅ DONE</option>
                                    </select>
                                    <button type="submit" class="p-2.5 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-100 active:scale-90">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </button>
                                </form>
                            </td>

                            <td class="px-8 py-6 text-right">
                                <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" onsubmit="return confirm('Hapus laporan ini secara permanen?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-300 hover:text-red-500 hover:bg-red-50 rounded-lg transition duration-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-32 text-center bg-slate-50/30">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-sm mb-4">
                                        <span class="text-4xl">📁</span>
                                    </div>
                                    <p class="text-slate-400 font-black uppercase tracking-[0.2em] text-[10px]">Data tidak ditemukan</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>