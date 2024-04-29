<?php

namespace Database\Seeders;

use App\Models\Pertanyaan;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PertanyaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        for($i = 1;$i<=20;$i++){
            $mytime = Carbon::now();
            $topik = Factory::create()->text(75);
            Pertanyaan::create([
                'judul'             => $topik, 
                'slug'              => Str::slug($topik), 
                'tag'               => 'programming, laravel, web, php', 
                'deskripsi'         => Factory::create()->text(rand(100, 200)), 
                'gambar'            => null, 
                'publik'            => 'Ya', 

                'kategori_id'       => rand(1,4), 
                'user_id'           => 1,

                'stat_publikasi'    => 'Ya', 
                'waktu_publikasi'   => $mytime->toDateTimeString(),
                'stat_selesai'      => 'Tidak',
            ]);
            sleep(rand(1,10));
        }
    }
}
