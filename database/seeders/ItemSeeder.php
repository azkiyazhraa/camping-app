<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'name' => 'Tenda Kecil',
                'image' => 'tendakecil.jpeg',
                'description' => 'Tenda ukuran compact untuk 1–2 orang, ringan dan mudah dirakit.Ideal untuk solo traveler atau pasangan yang ingin kepraktisan.',
                'stock' => 10,
            ],
            [
                'name' => 'Matras Lipat',
                'image' => 'matras.jpeg',
                'description' => 'Alas tidur tipis yang dapat digulung, ringan dan mudah disimpan.Memberikan kenyamanan tambahan saat tidur di atas tanah.',
                'stock' => 15,
            ],
            [
                'name' => 'Kompor Portable',
                'image' => 'kompor.jpeg',
                'description' => 'Kompor lipat berukuran kecil yang dapat digunakan dengan gas camping.Cocok untuk memasak cepat di area perkemahan atau perjalanan jauh.',
                'stock' => 8,
            ],
            [
                'name' => 'Lampu Camping',
                'image' => 'lampu.jpeg',
                'description' => 'Lampu gantung ringan dan hemat energi untuk penerangan di dalam tenda.Memberikan cahaya yang cukup di malam hari saat berkemah.',
                'stock' => 12,
            ],
            [
                'name' => 'Ransel Gunung',
                'image' => 'carrier.jpeg',
                'description' => 'Ransel besar khusus kegiatan outdoor dengan kapasitas besar dan banyak kompartemen.Dirancang ergonomis untuk kenyamanan saat membawa perlengkapan camping.',
                'stock' => 9,
            ],
            [
                'name' => 'Flysheet',
                'image' => 'flysheet.jpeg',
                'description' => 'Pelindung tambahan untuk tenda yang tahan terhadap panas dan hujan.Ideal digunakan sebagai atap tambahan atau shelter darurat.',
                'stock' => 11,
            ],
            [
                'name' => 'Senter Camping',
                'image' => 'senter.jpeg',
                'description' => 'Alat penerangan genggam dengan cahaya terang dan tahan lama.Ideal untuk eksplorasi malam atau keadaan darurat di alam bebas.',
                'stock' => 14,
            ],
            [
                'name' => 'Kursi Lipat',
                'image' => 'kursi.jpeg',
                'description' => 'Kursi lipat ringan dengan rangka kokoh untuk kenyamanan saat bersantai.Mudah dibawa dan dapat digunakan di berbagai medan outdoor.',
                'stock' => 7,
            ],
            [
                'name' => 'Gas',
                'image' => 'gas.jpeg',
                'description' => 'Tabung gas portable berukuran kecil untuk keperluan memasak di alam terbuka. Mudah digunakan, praktis dibawa, dan aman untuk aktivitas outdoor.',
                'stock' => 13,
            ],
            [
                'name' => 'Sleeping Bag',
                'image' => 'sleepingbag.jpeg',
                'description' => 'Kantong tidur yang dirancang untuk menjaga suhu tubuh tetap hangat.Cocok digunakan di suhu dingin saat berkemah atau mendaki.',
                'stock' => 10,
            ],
            [
                'name' => 'Set Alat Makan & Masak',
                'image' => 'set.jpeg',
                'description' => 'Perlengkapan memasak dan makan dalam satu paket praktis.Terdiri dari panci, wajan, sendok, garpu, dan perlengkapan lainnya.',
                'stock' => 6,
            ],
            [
                'name' => 'Tenda Besar',
                'image' => 'tendabesar.jpeg',
                'description' => 'Tenda berukuran luas yang mampu menampung 4–6 orang.Dirancang untuk kenyamanan berkelompok dalam kegiatan outdoor.',
                'stock' => 20,
            ],
        ];

        foreach ($items as $item) {
            Item::create($item);
        }
    }
}
