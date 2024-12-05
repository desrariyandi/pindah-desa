<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kecamatan::create([
            'id' => 1,
            'name' => "Tebing Tinggi",
        ]);
        Kecamatan::create([
            'id' => 2,
            'name' => "Rangsang Barat",
        ]);
        Kecamatan::create([
            'id' => 3,
            'name' => "Rangsang",
        ]);
        Kecamatan::create([
            'id' => 4,
            'name' => "Tebing Tinggi Barat",
        ]);
        Kecamatan::create([
            'id' => 5,
            'name' => "Merbau",
        ]);
        Kecamatan::create([
            'id' => 6,
            'name' => "Pulau Merbau",
        ]);
        Kecamatan::create([
            'id' => 7,
            'name' => "Tebing Tinggi Timur",
        ]);
        Kecamatan::create([
            'id' => 8,
            'name' => "Tasik Putri Puyu",
        ]);
        Kecamatan::create([
            'id' => 9,
            'name' => "Rangsang Pesisir",
        ]);
    }
}
