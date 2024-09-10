<?php

namespace Database\Seeders;

use App\Models\Mobil;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MobilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mobils = [
            [
                'merek' => 'Toyota',
                'model' => 'Avanza',
                'nomor_plat' => 'B 1234 CD',
                'tarif_sewa_per_hari' => 500000,
                'ketersediaan' => true,
            ],
            [
                'merek' => 'Honda',
                'model' => 'Civic',
                'nomor_plat' => 'D 5678 EF',
                'tarif_sewa_per_hari' => 750000,
                'ketersediaan' => true,
            ],
            [
                'merek' => 'Mitsubishi',
                'model' => 'Pajero Sport',
                'nomor_plat' => 'L 9101 GH',
                'tarif_sewa_per_hari' => 1200000,
                'ketersediaan' => false,
            ],
            [
                'merek' => 'Suzuki',
                'model' => 'Ertiga',
                'nomor_plat' => 'N 2345 IJ',
                'tarif_sewa_per_hari' => 600000,
                'ketersediaan' => true,
            ],
            [
                'merek' => 'Daihatsu',
                'model' => 'Terios',
                'nomor_plat' => 'F 6789 KL',
                'tarif_sewa_per_hari' => 700000,
                'ketersediaan' => true,
            ],
        ];

        foreach ($mobils as $mobil) {
            Mobil::create($mobil);
        }
    }
}
