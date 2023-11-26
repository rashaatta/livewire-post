<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=>'Rasha Atta',
            'email'=>'rashaatta83@gmail.com',
            'password'=>bcrypt('123123')
        ]);

        User::create([
            'name'=>'Reda Rezk',
            'email'=>'rmmz75@gmail.com',
            'password'=>bcrypt('123456')
        ]);
    }
}
