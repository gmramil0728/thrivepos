<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 50; $i++) {
            DB::table('customers')->insert([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'phone' => $faker->phoneNumber(),
                'address' => $faker->address(),
                'shopname' => $faker->company(),
                'image' => 'default.png', // prevent missing file issues
                'account_holder' => $faker->name(),
                'account_number' => $faker->bankAccountNumber(),
                'bank_name' => $faker->randomElement([
                    'BDO', 'BPI', 'Metrobank', 'LandBank', 'PNB', 'Security Bank'
                ]),
                'bank_branch' => $faker->city(),
                'city' => $faker->city(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
