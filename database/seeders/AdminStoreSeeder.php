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
    public static $num = 2;

    public function run(): void
    {

        Role::create(['name' =>'admin']);
        Role::create(['name' =>'team']);
        Role::create(['name' =>'client']);
        
        foreach(range(1, 10) as $team) {
            $this->runLoop();
            self::$num++;
        }
        
    }

    private function runLoop()
    {
        $user = User::create([
            'name' => 'client '. self::$num,
            'email' => 'client_'.self::$num.'@gmail.com',
            'password' => Hash::make('admin@123'),
            'parent' => 111
        ]);

        $user->assignRole('client');

        $team = User::create([
            'name' => 'team '. self::$num,
            'email' => 'team_'.self::$num.'@gmail.com',
            'password' => Hash::make('admin@123'),
            'parent' => 111
        ]);

        $team->assignRole('team');
    }
}
