<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.tickets.index') }}" class="p-2 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition shadow-sm">
                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <div>
                    <h2 class="font-black text-2xl text-slate-900 tracking-tight leading-none italic uppercase">Detail Laporan</h2>
                    <p class="text-[10px] font-bold text-indigo-500 uppercase tracking-[0.2em] mt-1">#{{ $ticket->ticket_number }}</p>
                </div>
            </div>
            
            <div class="px-5 py-2 {{ $ticket->status == 'done' ? 'bg-emerald-100 text-emerald-700' : ($ticket->status == 'process' ? 'bg-indigo-100 text-indigo-700' : 'bg-amber-100 text-amber-700') }} rounded-2xl text-xs font-black uppercase tracking-widest">
                Status: {{ $ticket->status }}
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-[3rem] overflow-hidden border border-slate-100 p-10 sm:p-16">
                
                <div class="flex flex-wrap items-center gap-3 mb-10">
                    <div class="flex items-center px-4 py-2 bg-indigo-50 text-indigo-700 rounded-2xl border border-indigo-100">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="text-[11px] font-black uppercase tracking-widest">{{ $ticket->created_at->translatedFormat('d F Y') }}</span>
                    </div>
                    <div class="flex items-center px-4 py-2 bg-slate-50 text-slate-600 rounded-2xl border border-slate-100">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="text-[11px] font-black uppercase tracking-widest">{{ $ticket->created_at->format('H:i') }} WIB</span>
                    </div>
                    <div class="px-4 py-2 bg-rose-50 text-rose-600 rounded-2xl border border-rose-100 text-[11px] font-black uppercase tracking-widest italic">
                        {{ $ticket->created_at->diffForHumans() }}
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <div class="space-y-8">
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 block">Pengirim / Instansi</label>
                            <p class="font-bold text-slate-800 text-lg uppercase">{{ $ticket->user->name }}</p>
                            <p class="text-sm font-medium text-indigo-600">{{ $ticket->instansi }}</p>
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 block">Kategori & Subjek</label>
                            <p class="text-xs font-black text-slate-500 bg-slate-100 px-3 py-1 rounded-lg inline-block mb-2 uppercase">{{ $ticket->category }}</p>
                            <p class="font-bold text-slate-800 leading-relaxed">{{ $ticket->title }}</p>
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 block">Deskripsi Keluhan</label>
                            <div class="bg-slate-50 p-6 rounded-[2rem] text-slate-700 leading-loose text-sm italic border border-slate-100">
                                "{{ $ticket->description }}"
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 block">Bukti Lampiran</label>
                        @if($ticket->image)
                            <a href="{{ asset('storage/' . $ticket->image) }}" target="_blank" class="group relative block overflow-hidden rounded-[2.5rem] shadow-2xl shadow-indigo-100">
                                <img src="{{ asset('storage/' . $ticket->image) }}" class="w-full h-auto object-cover transform group-hover:scale-110 transition duration-700">
                                <div class="absolute inset-0 bg-indigo-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <span class="bg-white px-6 py-2 rounded-full font-black text-[10px] uppercase tracking-widest text-indigo-700 shadow-xl">Lihat Fullscreen</span>
                                </div>
                            </a>
                        @else
                            <div class="aspect-square bg-slate-50 rounded-[2.5rem] border-2 border-dashed border-slate-200 flex flex-col items-center justify-center p-10 text-center">
                                <span class="text-4xl mb-3 text-slate-200 italic">No File</span>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tidak ada lampiran foto yang disertakan</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>