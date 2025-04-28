<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        app()['cache']->forget('spatie.permission.cache');

        $entities = [
            // Database => Database
            'product', 'akun-product',
            // Pengaturan
            'akun', 'peran', 'perizinan'
        ];

        $actions = ['menu', 'create', 'read', 'update', 'delete'];

        $permissions = [];
        foreach ($entities as $entity) {
            foreach ($actions as $action) {
                $permissions["{$entity}: {$action}"] = Permission::create(['name' => "{$entity}: {$action}"]);
            }
        }

        $rolesPermissions = [
            'root' => Permission::all(),
        ];

        foreach ($rolesPermissions as $roleName => $perms) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($perms);
        }

        $user = User::where('email', 'root@system.com')->first();
        $user->assignRole('root');
    }
}
