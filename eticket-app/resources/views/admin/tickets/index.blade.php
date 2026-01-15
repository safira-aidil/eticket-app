<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-extrabold text-2xl text-gray-900 leading-tight">
                {{ __('Panel Manajemen Admin (Semua Laporan)') }}
            </h2>
            <div class="px-4 py-2 bg-indigo-100 text-indigo-700 rounded-lg text-xs font-bold uppercase">
                Total: {{ $tickets->count() }} Laporan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-500 text-white rounded-2xl shadow-lg font-bold text-sm flex items-center gap-3 animate-bounce">
                    <span>✅</span> {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-xl rounded-[2rem] overflow-hidden border border-gray-100">
                <table class="w-full text-left border-separate border-spacing-0">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">User & Judul</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Lampiran</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Kelola Status</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($tickets as $ticket)
                        <tr class="hover:bg-indigo-50/30 transition group">
                            <td class="px-6 py-5">
                                <p class="text-[10px] text-indigo-500 font-bold mb-1 uppercase tracking-tighter">
                                    #{{ $ticket->ticket_number }} | OLEH: {{ $ticket->user->name ?? 'Anonim' }}
                                </p>
                                
                                <p class="font-bold text-gray-800 group-hover:text-indigo-600 transition">
                                    {{ $ticket->title }}
                                </p>
                                
                                <p class="text-xs text-gray-400 truncate w-64 italic">
                                    "{{ $ticket->description }}"
                                </p>
                            </td>

                            <td class="px-6 py-5 text-center">
                                <div class="flex justify-center">
                                    @if($ticket->image)
                                        <a href="{{ asset('storage/' . $ticket->image) }}" target="_blank" class="block">
                                            <img src="{{ asset('storage/' . $ticket->image) }}" class="w-12 h-12 object-cover rounded-xl shadow-sm border border-gray-200 hover:scale-110 transition">
                                        </a>
                                    @else
                                        <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center border border-dashed border-gray-200">
                                            <span class="text-gray-300 text-[10px] uppercase font-bold">No File</span>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <form action="{{ route('tickets.updateStatus', $ticket->id) }}" method="POST" class="flex items-center justify-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="text-[10px] font-black border-gray-200 rounded-lg bg-gray-50 focus:ring-indigo-500 focus:border-indigo-500 uppercase tracking-tighter">
                                        <option value="waiting" {{ $ticket->status == 'waiting' ? 'selected' : '' }}>WAITING</option>
                                        <option value="process" {{ $ticket->status == 'process' ? 'selected' : '' }}>PROCESS</option>
                                        <option value="done" {{ $ticket->status == 'done' ? 'selected' : '' }}>DONE</option>
                                    </select>
                                    <button type="submit" class="p-2 bg-indigo-700 text-white rounded-lg hover:bg-indigo-800 transition shadow-md active:scale-90" title="Simpan Perubahan">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex justify-end items-center gap-3">
                                    <span class="text-[10px] font-black text-gray-400 uppercase">{{ $ticket->created_at->format('d/m/y') }}</span>
                                    
                                    <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" onsubmit="return confirm('Hapus laporan ini secara permanen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-300 hover:text-red-500 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <span class="text-4xl mb-2">📁</span>
                                    <p class="text-gray-400 font-bold uppercase tracking-widest text-xs">Belum ada laporan yang masuk ke sistem.</p>
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