<?php

use App\Models\Ticket;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TicketController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        
        // Memastikan role terbaca benar (lowercase)
        $role = strtolower(trim($user->role));

        if ($role === 'admin') {
            // JIKA ADMIN (Safira): Ambil SEMUA tiket dari database
            $tickets = Ticket::with('user')->latest()->get();
            $isAdmin = true;

            // Statistik Global untuk Admin
            $stats = [
                'total'   => Ticket::count(),
                'waiting' => Ticket::where('status', 'waiting')->count(),
                'process' => Ticket::where('status', 'process')->count(),
                'done'    => Ticket::where('status', 'done')->count(),
            ];
        } else {
            // JIKA USER (Kirana/Rara/Suci): Hanya ambil miliknya sendiri
            $tickets = Ticket::where('user_id', $user->id)->latest()->get();
            $isAdmin = false;

            // Statistik Personal untuk User
            $stats = [
                'total'   => $tickets->count(),
                'waiting' => $tickets->where('status', 'waiting')->count(),
                'process' => $tickets->where('status', 'process')->count(),
                'done'    => $tickets->where('status', 'done')->count(),
            ];
        }

        return view('dashboard', compact('tickets', 'isAdmin', 'stats'));
    })->name('dashboard');

    Route::resource('tickets', TicketController::class);
});

require __DIR__.'/auth.php';