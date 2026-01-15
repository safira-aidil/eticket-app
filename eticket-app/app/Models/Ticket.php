<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    // Tambahkan baris ini agar semua kolom bisa diisi oleh Controller
    protected $fillable = [
        'ticket_number',
        'user_id',
        'instansi',
        'category',
        'title',
        'description',
        'image',
        'status',
        'priority',
        'admin_note'
    ];

    // Relasi ke User (Agar Admin bisa melihat siapa yang melapor)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}