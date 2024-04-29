<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jawaban extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "jawaban";
    protected $fillable = [
        'deskripsi', 
        'main_id', 

        'pertanyaan_id', 
        'user_id',
    ];

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
    
    public function vote(){
        return $this->hasMany('App\Models\VoteJawaban', 'jawaban_id', 'id');
    }
}
