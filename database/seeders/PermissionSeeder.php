<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'view customers',
            'view customer details',
            'create customers',
            'edit customers',
            'delete customers',

            'view operators',
            'view operator details',
            'create operators',
            'edit operators',
            'delete operators',

            'view roles',
            'create roles',
            'edit roles',
            'delete roles',

            'view destinations',
            'create destinations',
            'edit destinations',
            'delete destinations',

            'view tours',
            'create tours',
            'edit tours',
            'delete tours',

            'view bookings',
            'create bookings',
            'edit bookings',
            'delete bookings',

        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'guard_name' => 'admin_api',
                'name' => $permission
            ]);
        }
    }
}
