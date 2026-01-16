<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class AdminTicketController extends Controller
{
    // --- TAMBAHKAN METHOD INI ---
    public function dashboard()
    {
       $stats = [
        'total' => Ticket::count(),
        'waiting' => Ticket::where('status', 'waiting')->count(),
        'process' => Ticket::where('status', 'process')->count(),
        'done' => Ticket::where('status', 'done')->count(),
    ];

    // Variabel khusus untuk angka di sidebar
    $waitingCount = $stats['waiting'];

    $tickets = Ticket::with('user')->latest()->get();
    $isAdmin = true;

    return view('admin.dashboard', compact('tickets', 'stats', 'isAdmin', 'waitingCount'));
    }
    // ----------------------------

    public function index(Request $request)
    {
        $sort = $request->get('sort', 'latest');
        $statusFilter = $request->get('status'); 
        $query = Ticket::query();

        if ($statusFilter && in_array($statusFilter, ['waiting', 'process', 'done'])) {
            $query->where('status', $statusFilter);
        }

        if ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $tickets = $query->get();
        $stats = [
            'total' => Ticket::count(),
            'waiting' => Ticket::where('status', 'waiting')->count(),
            'process' => Ticket::where('status', 'process')->count(),
            'done' => Ticket::where('status', 'done')->count(),
        ];

        return view('admin.tickets.index', compact('tickets', 'stats'));
    }

    public function show(Ticket $ticket)
    {
        $ticket->load('user'); 
        return view('admin.tickets.show', compact('ticket'));
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        $request->validate(['status' => 'required|in:waiting,process,done']);
        $ticket->update(['status' => $request->status]);
        return back()->with('success', 'Status tiket berhasil diperbarui!');
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('admin.tickets.index')->with('success', 'Laporan berhasil dihapus!');
    }
}