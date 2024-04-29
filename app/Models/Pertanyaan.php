<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pertanyaan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "pertanyaan";
    protected $fillable = [
        'judul', 
        'slug', 
        'tag', 
        'deskripsi', 
        'gambar', 
        'publik', 

        'kategori_id', 
        'user_id',

        'stat_publikasi',
        'waktu_publikasi',
        'stat_selesai',
    ];

    public function kategori(){
        return $this->hasOne('App\Models\Kategori', 'id', 'kategori_id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function countjawaban(){
        return $this->hasOne('App\Models\Jawaban', 'pertanyaan_id', 'id');
    }

    public function jawaban(){
        return $this->hasMany('App\Models\Jawaban', 'pertanyaan_id', 'id');
    }
}
