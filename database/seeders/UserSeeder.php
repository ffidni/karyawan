<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory as Faker;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $tipe_user = ["admin", "karyawan"];

        for ($i = 0; $i <= 10; $i++) {
            User::create([
                "nama" => $faker->name(),
                'email' => $faker->email,
                'password' => $faker->password,
                'tipe_user' => $tipe_user[$faker->numberBetween(0, 1)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}