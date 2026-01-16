<?php

use App\Models\Ticket;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\Admin\AdminTicketController;

// 1. Beranda Utama (Welcome)
Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    
    // 2. DASHBOARD LOGIC (Mendukung Statistik & Beranda Admin)
    Route::get('/dashboard', function () {
        $user = Auth::user();
        $role = strtolower(trim($user->role));

        if ($role === 'admin') {
            // PERBAIKAN: Admin membuka Dashboard Admin, bukan redirect ke index
            return app(AdminTicketController::class)->dashboard();
        } else {
            // User melihat tiket mereka sendiri
            $tickets = Ticket::where('user_id', $user->id)->latest()->get();
            $isAdmin = false;
            $stats = [
                'total'   => $tickets->count(),
                'waiting' => $tickets->where('status', 'waiting')->count(),
                'process' => $tickets->where('status', 'process')->count(),
                'done'    => $tickets->where('status', 'done')->count(),
            ];
            return view('dashboard', compact('tickets', 'isAdmin', 'stats'));
        }
    })->name('dashboard');

    // 3. TICKET ROUTES
    Route::resource('tickets', TicketController::class);
    Route::get('/my-tickets', [TicketController::class, 'myTickets'])->name('my.tickets');

    // 4. ADMIN ROUTES
    Route::prefix('admin')->name('admin.')->group(function () {
        // Ini adalah route untuk Beranda Utama Admin yang kamu maksud
        Route::get('/dashboard', [AdminTicketController::class, 'dashboard'])->name('dashboard');
        
        Route::get('/tickets', [AdminTicketController::class, 'index'])->name('tickets.index');
        Route::get('/tickets/{ticket}', [AdminTicketController::class, 'show'])->name('tickets.show');
    });

    // 5. AKSI STATUS & HAPUS
    Route::patch('/tickets/{ticket}/status', [AdminTicketController::class, 'updateStatus'])->name('tickets.updateStatus');
    Route::delete('/tickets/{ticket}', [AdminTicketController::class, 'destroy'])->name('tickets.destroy');
});

require __DIR__.'/auth.php';