<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminStoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678')
        ]);

        Role::insert([
            ['name' => 'admin','guard_name' => 'web'], ['name' => 'team','guard_name' => 'web'], ['name' => 'client','guard_name' => 'web']
        ]);

        $user->assignRole('admin');
    }
}
