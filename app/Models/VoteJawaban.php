<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoteJawaban extends Model
{
    use HasFactory;

    protected $table = "votejawaban";
    protected $fillable = [
        'user_id',
        'jawaban_id', 
        'vote', 
    ];
}
