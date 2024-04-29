<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    use HasFactory;

    protected $table    = "profil";
    protected $fillable = [
        'user_id',
        'umur',
        'biodata',
        'alamat',
        'email',
    ];
}
