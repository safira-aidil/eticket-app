<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-indigo-500">
                    <p class="text-sm text-gray-500 uppercase font-bold">Total Laporan</p>
                    <p class="text-3xl font-black text-gray-800">{{ $stats['total'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-yellow-500">
                    <p class="text-sm text-gray-500 uppercase font-bold">Menunggu</p>
                    <p class="text-3xl font-black text-gray-800">{{ $stats['waiting'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-500">
                    <p class="text-sm text-gray-500 uppercase font-bold">Selesai</p>
                    <p class="text-3xl font-black text-gray-800">{{ $stats['done'] }}</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-3 px-2">No. Tiket</th>
                            @if($isAdmin) <th class="text-left py-3 px-2">Pengirim</th> @endif
                            <th class="text-left py-3 px-2">Instansi</th>
                            <th class="text-left py-3 px-2">Subjek</th>
                            <th class="text-left py-3 px-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- PERBAIKAN: Mengganti $latestTickets menjadi $tickets sesuai kiriman dari Route --}}
                        @foreach($tickets as $ticket)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-2">{{ $ticket->ticket_number }}</td>
                            {{-- Menggunakan optional ?? agar tidak error jika user kosong --}}
                            @if($isAdmin) <td class="py-3 px-2 font-bold">{{ $ticket->user->name ?? 'User N/A' }}</td> @endif
                            <td class="py-3 px-2 uppercase">{{ $ticket->instansi }}</td>
                            <td class="py-3 px-2">{{ $ticket->title }}</td>
                            <td class="py-3 px-2">
                                <span class="px-2 py-1 text-xs rounded font-bold {{ $ticket->status == 'waiting' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">
                                    {{ strtoupper($ticket->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>