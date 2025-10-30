<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create first admin account
        User::firstOrCreate(
            ['email' => 'suba@dyits.com.my'],
            [
                'name' => 'Suba Admin',
                'password' => Hash::make('NewAdmin@123'),
                'role' => 'admin',
                'status' => 'active',
                'university_id' => null,
            ]
        );

        // Create second admin account
        User::firstOrCreate(
            ['email' => 'mcruwan@gmail.com'],
            [
                'name' => 'Ruwan Admin',
                'password' => Hash::make('NewAdmin@333'),
                'role' => 'admin',
                'status' => 'active',
                'university_id' => null,
            ]
        );

        $this->command->info('Admin accounts created successfully!');
        $this->command->info('Email: suba@dyits.com.my | Password: NewAdmin@123');
        $this->command->info('Email: mcruwan@gmail.com | Password: NewAdmin@333');
    }
}

