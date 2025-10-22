<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $user = User::create([
            'name'=>'Shohjaxon',
            'last_name'=>'Xurramov',
            'middle_name'=>'Shunkor o\'g\'li',
            'email'=>'sh@gmail.com',
            'password'=>Hash::make('secret'),
        ]);
        
        $user->roles()->attach([1]);
        
        $user2 = User::create([
            'name'=>'Abbos',
            'last_name'=>'Abbosov',
            'middle_name'=>'Abbos o\'g\'li',
            'email'=>'a@gmail.com',
            'phone'=>'1234567890',
            'password'=>Hash::make('secret'),
        ]);
        
        $user2->roles()->attach([2]);
        
        $user3 = User::create([
            'name'=>'Bexruz',
            'last_name'=>'Bexruzov',
            'middle_name'=>'Bexruz o\'g\'li',
            'email'=>'b@gmail.com',
            'password'=>Hash::make('secret'),
        ]);
        
        $user3->roles()->attach([3]);

        $user4 = User::create([
            'name'=>'Zulhumor',
            'last_name'=>'Zulhumorova',
            'middle_name'=>'Zulhumor qizi',
            'email'=>'z@gmail.com',
            'phone'=>'1234567890',
            'password'=>Hash::make('secret'),
            'payment_id' => 2,
            'group_id' => 1,
        ]);
        
        $user4->roles()->attach([2]);
        
        User::factory()->count(20)->create()->each(function ($user) {
            $user->roles()->attach(Role::where('name', 'admin')->first()); // "admin" rolini berish
        });


        // Guests logins
        $user5 = User::create([
            'name'=>'Admin',
            'last_name'=>'Admin Guest',
            'email'=>'admin@gmail.com',
            'password'=>Hash::make('admin'),
        ]);
        
        $user5->roles()->attach([1]);

        $user6 = User::create([
            'name'=>'Student',
            'last_name'=>'Student Guest',
            'email'=>'student@gmail.com',
            'group_id' => 1,
            'password'=>Hash::make('student'),
        ]);
        
        $user6->roles()->attach([2]);

        $user7 = User::create([
            'name'=>'Teacher',
            'last_name'=>'Teacher Guest',
            'email'=>'teacher@gmail.com',
            'password'=>Hash::make('teacher'),
        ]);
        
        $user7->roles()->attach([3]);
    }
}
