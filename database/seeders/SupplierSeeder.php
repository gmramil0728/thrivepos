<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 50; $i++) {
            DB::table('suppliers')->insert([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'phone' => $faker->phoneNumber(),
                'address' => $faker->address(),
                'shopname' => $faker->company(),
                'image' => 'default.png', // avoid file delete errors
                'type' => $faker->randomElement([
                    'Local', 'International', 'Distributor', 'Wholesaler'
                ]),
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
