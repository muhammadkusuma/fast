<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah email sudah ada agar tidak duplikat
        if (! User::where('email', 'admin@fast.com')->exists()) {
            User::create([
                'name'              => 'Super Administrator',
                'email'             => 'admin@fast.com',
                'password'          => Hash::make('password'), // Password default
                'email_verified_at' => now(),
                
            ]);
        }
    }
}
