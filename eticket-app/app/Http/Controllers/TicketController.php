<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    public function index()
    {
        // Mengambil tiket hanya milik user yang sedang login
        $tickets = Ticket::where('user_id', Auth::id())->latest()->get();
        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        // Validasi: 'priority' dibuat nullable agar tidak menghambat pengiriman form
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('tickets', 'public');
        }

        Ticket::create([
            'title'       => $request->title,
            'category'    => $request->category,
            'description' => $request->description,
            'image'       => $imagePath,
            'status'      => 'waiting',
            'priority'    => $request->priority ?? 'low', // Default ke 'low' jika form kosong
        ]);

        return redirect()->route('tickets.index')->with('success', 'Laporan Anda berhasil dikirim!');
    }
}