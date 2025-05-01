<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);
        $agentRole = Role::create(['name' => 'agent']);
        $superAdminRole = Role::create(['name' => 'super admin']);

        // Get permissions from the PermissionsSeeder
        $permissions = Permission::all();

        // Assign permissions to roles
        $superAdminRole->givePermissionTo($permissions);

        // Assign specific permissions to other roles
        $userRole->givePermissionTo([
            'create tickets',
            'show tickets',
            'view labels',
        ]);

        $agentRole->givePermissionTo([
            'view permissions',
            'view roles',
            'view users',
            'edit tickets',
            'view tickets',
            'show tickets',
        ]);
        
        $adminRole->givePermissionTo([
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
        ]);
        
    }
}
