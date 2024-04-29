<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $arr = [
            'Laravel',
            'HTML',
            'CSS',
            'Java Script',
        ];

        foreach($arr as $val){
            Kategori::create([
                'nama'  => $val
            ]);
        }
    }
}
