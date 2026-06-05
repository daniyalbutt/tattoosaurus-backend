<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // make sure the admin role exists (safe if RoleSeeder already created it)
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        // create (or fetch) the admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@tattoosaurus.com'],   // unique key — won't duplicate on re-run
            [
                'name'              => 'Super Admin',
                'username'          => 'admin',
                'phone'             => '0000000000',
                'password'          => Hash::make('@Admin!@#'),
                'status'            => 'active',
                'email_verified_at' => now(),
            ]
        );

        // assign the admin role (assignRole is idempotent — safe to re-run)
        if (! $admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }
    }
}