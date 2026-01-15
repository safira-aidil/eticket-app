<?php

use App\Models\Ticket;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TicketController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    
    // --- DASHBOARD LOGIC ---
    Route::get('/dashboard', function () {
        $user = Auth::user();
        $role = strtolower(trim($user->role));

        if ($role === 'admin') {
            $tickets = Ticket::with('user')->latest()->get();
            $isAdmin = true;
            $stats = [
                'total'   => Ticket::count(),
                'waiting' => Ticket::where('status', 'waiting')->count(),
                'process' => Ticket::where('status', 'process')->count(),
                'done'    => Ticket::where('status', 'done')->count(),
            ];
        } else {
            $tickets = Ticket::where('user_id', $user->id)->latest()->get();
            $isAdmin = false;
            $stats = [
                'total'   => $tickets->count(),
                'waiting' => $tickets->where('status', 'waiting')->count(),
                'process' => $tickets->where('status', 'process')->count(),
                'done'    => $tickets->where('status', 'done')->count(),
            ];
        }

        return view('dashboard', compact('tickets', 'isAdmin', 'stats'));
    })->name('dashboard');

    // --- TICKET ROUTES ---
    
    // 1. Menggunakan Resource (Otomatis mencakup index, create, store, edit, update, show)
    Route::resource('tickets', TicketController::class);

    // 2. Route tambahan untuk filter "Tiket Saya"
    Route::get('/my-tickets', [TicketController::class, 'myTickets'])->name('my.tickets');

    // 3. Route khusus aksi Admin
    Route::patch('/tickets/{ticket}/status', [TicketController::class, 'updateStatus'])->name('tickets.updateStatus');
    // Note: Route::delete sudah dicover oleh Route::resource di atas, 
    // tapi tidak apa-apa jika ingin ditulis spesifik di bawahnya.
    Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');
});

require __DIR__.'/auth.php';