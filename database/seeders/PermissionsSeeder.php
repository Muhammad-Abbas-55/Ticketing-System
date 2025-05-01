<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            'create permissions',
            'delete permissions',
            'edit permissions',
            'view permissions',
            'create roles',
            'delete roles',
            'edit roles',
            'view roles',
            'delete users',
            'edit users',
            'view users',
            'create tickets',
            'delete tickets',
            'edit tickets',
            'view tickets',
            'show tickets',
            'create categories',
            'delete categories',
            'edit categories',
            'view categories',
            'create labels',
            'delete labels',
            'edit labels',
            'view labels',
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
