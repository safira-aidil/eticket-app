<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import ini penting
use Illuminate\Support\Str;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_number', 
        'user_id', 
        'category', 
        'title', 
        'description', 
        'image', 
        'status', 
        'priority'
    ];

    /**
     * RELASI: Menghubungkan Tiket ke User
     * Ini yang memperbaiki error "Attempt to read property name on null"
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * LOGIKA OTOMATIS: Dijalankan saat tiket dibuat
     */
    protected static function booted()
    {
        static::creating(function ($ticket) {
            // 1. Membuat nomor tiket otomatis (Contoh: TCK-AB123)
            if (!$ticket->ticket_number) {
                $ticket->ticket_number = 'TCK-' . strtoupper(Str::random(5));
            }
            
            // 2. Mengisi user_id otomatis dari siapa yang sedang login
            if (auth()->check()) {
                $ticket->user_id = auth()->id();
            }
        });
    }
}