<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Hewan;
use Illuminate\Database\Seeder;

class CreateAnimalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mamalia = Genre::create([
            'id' => 1,
            'genre' => 'Mamalia',
            'keterangan' => 'Mamalia adalah',
            'status' => 1,
        ]);

        $ikan = Genre::create([
            'id' => 2,
            'genre' => 'Ikan',
            'keterangan' => 'Ikan adalah',
            'status' => 1,
        ]);

        $serangga = Genre::create([
            'id' => 3,
            'genre' => 'Serangga',
            'keterangan' => 'Serangga adalah',
            'status' => 1,
        ]);

        $unggas = Genre::create([
            'id' => 4,
            'genre' => 'Unggas',
            'keterangan' => 'Unggas adalah',
            'status' => 1,
        ]);

        $kuda = Hewan::create([
            'id_genre' => $mamalia->id,
            'nama' => 'Kuda',
            'objek' => 'img/kuda.jpeg',
            'editor' => '<div class="sketchfab-embed-wrapper"> <iframe title="Horse-skeleton" frameborder="0" allowfullscreen mozallowfullscreen="true" webkitallowfullscreen="true" allow="autoplay; fullscreen; xr-spatial-tracking" xr-spatial-tracking execution-while-out-of-viewport execution-while-not-rendered web-share src="https://sketchfab.com/models/f3cbabd52905467884c6392963be0d38/embed"> </iframe> <p style="font-size: 13px; font-weight: normal; margin: 5px; color: #4A4A4A;"> <a href="https://sketchfab.com/3d-models/horse-skeleton-f3cbabd52905467884c6392963be0d38?utm_medium=embed&utm_campaign=share-popup&utm_content=f3cbabd52905467884c6392963be0d38" target="_blank" style="font-weight: bold; color: #1CAAD9;"> Horse-skeleton </a> by <a href="https://sketchfab.com/eragilangm?utm_medium=embed&utm_campaign=share-popup&utm_content=f3cbabd52905467884c6392963be0d38" target="_blank" style="font-weight: bold; color: #1CAAD9;"> eragilangm </a> on <a href="https://sketchfab.com?utm_medium=embed&utm_campaign=share-popup&utm_content=f3cbabd52905467884c6392963be0d38" target="_blank" style="font-weight: bold; color: #1CAAD9;">Sketchfab</a></p></div>',
            'keterangan' => 'Kuda adalah',
            'status' => 1,
        ]);

        Hewan::create([
            'id_genre' => $mamalia->id,
            'nama' => 'Sapi',
            'objek' => 'img/sapi.jpg',
            'editor' => '',
            'keterangan' => '',
            'status' => 1,
        ]);

        Hewan::create([
            'id_genre' => $ikan->id,
            'nama' => 'Hiu',
            'objek' => 'img/hiu.jpg',
            'editor' => '',
            'keterangan' => '',
            'status' => 1,
        ]);

    }
}
