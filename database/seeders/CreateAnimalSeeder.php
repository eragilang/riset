<?php

namespace Database\Seeders;

use App\Models\DetailHewan;
use App\Models\Genre;
use App\Models\Hewan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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

        $this->command->info("Genre berhasil ditambahkan");

        $kuda = Hewan::create([
            'id_genre' => $mamalia->id,
            'nama' => 'Kuda',
            'objek' => 'img/kuda.jpeg',
            'editor' => '<div class="sketchfab-embed-wrapper"><iframe title="Horse-skeleton" frameborder="0" allowfullscreen mozallowfullscreen="true" webkitallowfullscreen="true" allow="autoplay; fullscreen; xr-spatial-tracking" xr-spatial-tracking execution-while-out-of-viewport execution-while-not-rendered web-share src="https://sketchfab.com/models/f3cbabd52905467884c6392963be0d38/embed"> </iframe></div>',
            'keterangan' => 'Kuda adalah',
            'status' => 1,
        ]);

        $kakiKuda = DetailHewan::create([
            'id_hewan' => $kuda->id,
            'nama' => 'Kaki Kuda',
            'keterangan' => 'Kaki Kuda adalah',
            'editor' => '<div class="sketchfab-embed-wrapper"> <iframe title="kaki_kuda" frameborder="0" allowfullscreen mozallowfullscreen="true" webkitallowfullscreen="true" allow="autoplay; fullscreen; xr-spatial-tracking" xr-spatial-tracking execution-while-out-of-viewport execution-while-not-rendered web-share src="https://sketchfab.com/models/65af4f7b54f74e75a4fce0442edd4d07/embed"> </iframe></div>',
            'status' => 1,
        ]);

        $this->command->info("Simpan file ".Storage::disk('public')->put($kuda->objek, File::get(public_path($kuda->objek))));

        $sapi = Hewan::create([
            'id_genre' => $mamalia->id,
            'nama' => 'Sapi',
            'objek' => 'img/sapi-16-9.jpg',
            'editor' => '',
            'keterangan' => 'Sapi adalah',
            'status' => 1,
        ]);

        Storage::disk('public')->put($sapi->objek, File::get(public_path($sapi->objek)));

        $ikan = Hewan::create([
            'id_genre' => $ikan->id,
            'nama' => 'Hiu',
            'objek' => 'img/hiu.jpg',
            'editor' => '',
            'keterangan' => 'Hiu adalah',
            'status' => 1,
        ]);

        Storage::disk('public')->put($ikan->objek, File::get(public_path($ikan->objek)));

        $this->command->info("Hewan berhasil ditambahkan");
    }
}
