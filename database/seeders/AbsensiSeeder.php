<?php

namespace Database\Seeders;

use App\Models\Absensi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AbsensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $status = ["hadir", "izin"];
        $tipe = ["masuk", "keluar"];

        for ($i = 0; $i <= 10; $i++) {
            Absensi::create([
                "user_id" => $faker->numberBetween(1, 10),
                "tanggal" => $faker->dateTimeBetween('-1 year', 'now'),
                "telat_waktu" => $faker->numberBetween(0, 60),
                'status' => $status[$faker->numberBetween(0, 1)],
                'tipe' => $tipe[$faker->numberBetween(0, 1)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}