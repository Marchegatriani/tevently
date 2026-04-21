<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah admin sudah ada
        $adminExists = User::where('email', 'admin@eticketing.com')->exists();

        if (!$adminExists) {
            User::create([
                'name' => 'Super Admin Tevently',
                'email' => 'admin@tevently.com',
                'password' => Hash::make('admin1123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);

            $this->command->info('Admin account created successfully!');
        } else {
            $this->command->warn('Admin account already exists!');
        }
    }
}