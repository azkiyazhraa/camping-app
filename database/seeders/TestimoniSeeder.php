<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimoni;

class TestimoniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonis = [
            [
                'name' => 'Kolil',
                'message' => 'Pelayanan cepat dan alat-alat campingnya lengkap banget! Proses peminjaman juga gampang. Cocok buat yang suka camping tapi nggak punya perlengkapan sendiri.',
                'photo' => 'testimoni/kol.jpg', 
                'rating' => 5,
            ],
            [
                'name' => 'Mega',
                'message' => 'Senang banget bisa pinjam alat camping tanpa ribet. Dulu susah nyari tenda, sekarang tinggal klik-klik aja. Recommended!',
                'photo' => 'testimoni/mega.jpg',
                'rating' => 4,
            ],
            [
                'name' => 'Cikacu',
                'message' => 'Barang sesuai deskripsi dan dalam kondisi baik. Tampilan aplikasinya simpel, mudah dipakai. Mantap banget, bakal langganan ke sini terus!',
                'photo' => 'testimoni/jamet.jpg',
                'rating' => 5,
            ],
        ];

        foreach ($testimonis as $testimoni) {
            Testimoni::create($testimoni);
        }
    }
}
