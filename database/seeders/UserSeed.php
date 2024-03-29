<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'type' => '0',
            'email_verified_at' => now(),
            'remember_token' => null,
        ]);
        $user->assignRole('Super Admin');

        $accountant = User::create([
            'name' => 'Accountant',
            'email' => 'accountant@test.com',
            'password' => bcrypt('password'),
            'type' => '3',
            'email_verified_at' => now(),
            'remember_token' => null,
        ]);
        $accountant->assignRole('Accountant');
    }
}
