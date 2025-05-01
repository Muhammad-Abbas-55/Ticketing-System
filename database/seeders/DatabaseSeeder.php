<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Roles
        $roles = ['super admin', 'admin', 'agent', 'user'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
        // Create Users
        $superAdminUser = User::firstOrCreate(
            ['email' => 'ali@gmail.com'],
            [
                'name' => 'Ali',
                'password' => Hash::make('alialiali'),
            ]
        );

        $adminUser = User::firstOrCreate(
            ['email' => 'abbas@gmail.com'],
            [
                'name' => 'Abbas',
                'password' => Hash::make('abbasabbas'),
            ]
        );

        $agentUser1 = User::firstOrCreate(
            ['email' => 'sadaqat@gmail.com'],
            [
                'name' => 'Sadaqat',
                'password' => Hash::make('sadaqatsadaqat'),
            ]
        );

        $agentUser2 = User::firstOrCreate(
            ['email' => 'shujaat@gmail.com'],
            [
                'name' => 'Shujaat',
                'password' => Hash::make('shujaatshujaat'),
            ]
        );

        $normalUser = User::firstOrCreate(
            ['email' => 'anwar@gmail.com'],
            [
                'name' => 'Anwar',
                'password' => Hash::make('anwaranwar'),
            ]
        );

        // Assign Roles to Users
        $superAdminUser->assignRole('super admin');
        $adminUser->assignRole('admin');
        $agentUser1->assignRole('agent');
        $agentUser2->assignRole('agent');
        $normalUser->assignRole('user');

        
        $this->call([
            PermissionsSeeder::class,
            RolesSeeder::class,
        ]);
    }
}
