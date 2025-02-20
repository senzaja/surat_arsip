<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordResets extends Model
{
    use HasFactory;

    protected $table = 'password_resets';
    protected $primaryKey = 'email';  // Kolom email sebagai primary key
    public $timestamps = false;
    public $incrementing = false;  // Menonaktifkan auto-increment

    protected $fillable = [
        'email',
        'token',
        'created_at',
    ];
}

