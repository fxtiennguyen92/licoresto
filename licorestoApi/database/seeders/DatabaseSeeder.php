<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Roles
        $superRole = Role::create(['name' => 'Super Admin']);

        // Permissions
        $permission = Permission::create(['name' => 'all']);

        // Assign Permission to Role
        $superRole->givePermissionTo($permission);

        // Accounts
        $super = User::create([
            'id' => Uuid::uuid4(),
            'name' => 'Super Admin',
            'email' => 'super@licortech.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
        $super->assignRole($superRole);
    }
}
