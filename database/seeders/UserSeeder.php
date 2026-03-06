<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@yitte.yi',
                'phone' => '00221771234567',
                'password' => Hash::make('Passer123!'),
                'role_id' => Role::where('name', 'Admin')->first()->id,
            ],
            [
                'name' => 'User 1',
                'email' => 'user1@yitte.yi',
                'phone' => '00221770009988',
                'password' => Hash::make('Passer123!'),
                'role_id' => Role::where('name', 'User')->first()->id,
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate([
                'email' => $user['email'],
            ], $user);
        }
    }
}
