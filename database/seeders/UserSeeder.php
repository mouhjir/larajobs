<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (User::where('email', 'admin@gmail.com')->count() == 0) {
            $user = new User();
            $user->password = Hash::make('admin123');
            $user->email = 'admin@gmail.com';
            $user->name = 'admin';
            $user->save();
        }
    }
}
