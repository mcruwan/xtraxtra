<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create super admin user if doesn't exist
        User::firstOrCreate(
            ['email' => 'admin@xtraxtra.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'status' => 'active',
                'university_id' => null,
            ]
        );

        $this->command->info('Super Admin user created successfully!');
        $this->command->info('Email: admin@xtraxtra.com');
        $this->command->info('Password: password');
    }
}
