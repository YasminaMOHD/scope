<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'name' => 'super-admin',
            'email' => 'scopeads3@gmail.com',
            'password' => Hash::make('super123$$'),
            'user_type' => 'super-admin'
        ]);
        \App\Models\User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123$$'),
            'user_type' => 'admin'
        ]);
    }
}
