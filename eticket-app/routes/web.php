<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\Admin\AdminTicketController;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    
    // --- SATU PINTU DASHBOARD ---
    // Kode ini akan mendeteksi usertype dan mengirim data yang berbeda
    Route::get('/dashboard', function () {
        $user = Auth::user();
        
        if ($user->usertype === 'admin') {
            // DATA UNTUK ADMIN
            $data = [
                'total'         => Ticket::count(), 
                'waiting'       => Ticket::where('status', 'waiting')->count(),
                'process'       => Ticket::where('status', 'process')->count(),
                'done'          => Ticket::where('status', 'done')->count(),
                'totalUser'     => User::where('usertype', 'user')->count(),
                'latestTickets' => Ticket::with('user')->latest()->take(5)->get(),
                'isAdmin'       => true // Penanda di Blade
            ];
        } else {
            // DATA UNTUK USER
            $data = [
                'total'         => Ticket::where('user_id', $user->id)->count(),
                'process'       => Ticket::where('user_id', $user->id)->whereIn('status', ['process', 'processing'])->count(),
                'done'          => Ticket::where('user_id', $user->id)->where('status', 'done')->count(),
                'latestTickets' => Ticket::where('user_id', $user->id)->latest()->take(5)->get(),
                'isAdmin'       => false // Penanda di Blade
            ];
        }

        return view('dashboard', $data);
    })->name('dashboard');

    // Route Resource Tiket untuk User
    Route::resource('tickets', TicketController::class);

    // --- JALUR KHUSUS ADMIN (Hanya untuk fungsi manajemen) ---
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        // Hapus Route::get('/dashboard') di sini agar tidak bentrok
        Route::get('/tickets', [AdminTicketController::class, 'index'])->name('tickets.index');
        Route::patch('/tickets/{ticket}/status', [AdminTicketController::class, 'updateStatus'])->name('tickets.updateStatus');
    });

    // --- PROFILE ---
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
});

require __DIR__.'/auth.php';