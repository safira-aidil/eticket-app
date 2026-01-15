<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\Admin\AdminTicketController;
use App\Models\Ticket;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    
    // RUTE UTAMA: Semua user (Admin & User) masuk lewat sini
    Route::get('/dashboard', function () {
        $user = Auth::user();
        
        // Pengecekan kolom 'role' sesuai struktur tabel Anda
        if ($user->role === 'admin') {
            return view('dashboard', [
                'stats' => [
                    'total'   => Ticket::count(),
                    'waiting' => Ticket::where('status', 'waiting')->count(),
                    'process' => Ticket::where('status', 'process')->count(),
                    'done'    => Ticket::where('status', 'done')->count(),
                ],
                'todayCount'    => Ticket::whereDate('created_at', now())->count(),
                'urgentCount'   => Ticket::where('status', 'waiting')->count(),
                'latestTickets' => Ticket::with('user')->latest()->take(5)->get(),
                'isAdmin'       => true // Variabel ini untuk memunculkan desain Admin
            ]);
        }

        // Tampilan untuk User biasa (seperti Kirana)
        return view('dashboard', [
            'stats' => [
                'total'   => Ticket::where('user_id', $user->id)->count(),
                'process' => Ticket::where('user_id', $user->id)->whereIn('status', ['process', 'processing'])->count(),
                'done'    => Ticket::where('user_id', $user->id)->where('status', 'done')->count(),
            ],
            'latestTickets' => Ticket::where('user_id', $user->id)->latest()->take(5)->get(),
            'isAdmin'       => false
        ]);
    })->name('dashboard');

    Route::resource('tickets', TicketController::class);

    // Proteksi area Admin
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/tickets', [AdminTicketController::class, 'index'])->name('tickets.index');
        Route::patch('/tickets/{ticket}/status', [AdminTicketController::class, 'updateStatus'])->name('tickets.updateStatus');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
});

require __DIR__.'/auth.php';