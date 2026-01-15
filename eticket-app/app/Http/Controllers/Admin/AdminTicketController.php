<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class AdminTicketController extends Controller
{
    public function index()
    {
        // Admin melihat semua tiket dari seluruh user
        $tickets = Ticket::latest()->get();
        return view('admin.tickets.index', compact('tickets'));
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        $request->validate([
            'status' => 'required|in:waiting,process,done',
        ]);

        $ticket->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Status tiket berhasil diperbarui!');
    }
}