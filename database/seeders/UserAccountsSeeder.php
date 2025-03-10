<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class UserAccountsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $users = [
            ['firstName' => 'John', 'lastName' => 'Doe', 'gender' => 'male'],
            ['firstName' => 'Jane', 'lastName' => 'Smith', 'gender' => 'female'],
            ['firstName' => 'Michael', 'lastName' => 'Johnson', 'gender' => 'male'],
            ['firstName' => 'Emily', 'lastName' => 'Clark', 'gender' => 'female'],
            ['firstName' => 'David', 'lastName' => 'Lee', 'gender' => 'male'],
            ['firstName' => 'Sophia', 'lastName' => 'Williams', 'gender' => 'female'],
            ['firstName' => 'Chris', 'lastName' => 'Brown', 'gender' => 'male'],
            ['firstName' => 'Olivia', 'lastName' => 'Martinez', 'gender' => 'female'],
            ['firstName' => 'Daniel', 'lastName' => 'Garcia', 'gender' => 'male'],
            ['firstName' => 'Mia', 'lastName' => 'Lopez', 'gender' => 'female'],
        ];

        foreach ($users as $user) {
            $username = strtolower($user['firstName'] . '_' . $user['lastName']) . rand(100, 999);

            DB::table('user_accounts')->updateOrInsert(
                ['username' => $username],
                [
                    'firstName' => $user['firstName'],
                    'lastName' => $user['lastName'],
                    'username' => $username,
                    'age' => rand(20, 40),
                    'gender' => $user['gender'],
                    'adrHouseNo' => rand(100, 999),
                    'adrZone' => 'Zone ' . rand(1, 10),
                    'adrStreet' => $faker->streetName,
                    'birthday' => $faker->date('Y-m-d', '2005-01-01'),
                    'password' => Hash::make('password123'),
                    'user_profile_picture' => 'profiles/' . Str::random(10) . '.jpg',
                    'user_valid_id' => 'valid_ids/valid_id_front_' . $username . '.jpg',
                    'user_valid_id_back' => 'valid_ids/valid_id_back_' . $username . '.jpg',
                    'last_active' => now(),
                    'status' => $faker->randomElement(['verified', 'pending', 'rejected']),
                ]
            );
        }
    }
}
