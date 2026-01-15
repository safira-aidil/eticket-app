<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Admin melihat semua, User melihat miliknya sendiri
        if (strtolower(trim($user->role)) === 'admin') {
            $tickets = Ticket::with('user')->latest()->get();
        } else {
            $tickets = Ticket::where('user_id', $user->id)->latest()->get();
        }
        return view('tickets.index', compact('tickets'));
    }

    // TAMBAHKAN METHOD INI AGAR ERROR "Undefined Method" HILANG
    public function create()
    {
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'instansi'    => 'required|string', 
            'category'    => 'required',
            'description' => 'required',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:10000',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('tickets', 'public');
        }

        $ticket = Ticket::create([
            'ticket_number' => 'TCK-' . strtoupper(Str::random(6)), 
            'user_id'       => Auth::id(), 
            'title'         => $validated['title'],
            'instansi'      => $validated['instansi'],
            'category'      => $validated['category'],
            'description'   => $validated['description'],
            'image'         => $imagePath,
            'status'        => 'waiting',
            'priority'      => $request->priority ?? 'low',
        ]);

        // Debug kalau mau
        // dd('SAMPAI SINI', $ticket);

        return redirect()->route('dashboard')
            ->with('success', 'Laporan berhasil terkirim!');
    }

}