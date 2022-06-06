<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Status;
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
            'email' => 'asfand@scoperealestatedubai.com',
            'password' => Hash::make('super123$$'),
            'user_type' => 'super-admin'
        ]);
        \App\Models\User::create([
            'name' => 'admin',
            'email' => 'abdullahassani065@gmail.com',
            'password' => Hash::make('admin123$$'),
            'user_type' => 'admin'
        ]);
        \App\Models\Status::create([
            'name' => 'Undefined',
            'color' => '#6c757d',
            'icon' => '<i class="fas fa-exclamation-circle"></i>'
        ]);
    }
}
