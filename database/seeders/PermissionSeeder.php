<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create([
            'name' => 'Dashboard'
        ]);

        Permission::create([
            'name' => 'Role Index'
        ]);
        Permission::create([
            'name' => 'Role Create'
        ]);
        Permission::create([
            'name' => 'Role Edit'
        ]);
        Permission::create([
            'name' => 'Role Delete'
        ]);

        Permission::create([
            'name' => 'Permission Index'
        ]);
        Permission::create([
            'name' => 'Permission Create'
        ]);
        Permission::create([
            'name' => 'Permission Edit'
        ]);
        Permission::create([
            'name' => 'Permission Delete'
        ]);

        Permission::create([
            'name' => 'User Index'
        ]);
        Permission::create([
            'name' => 'User Create'
        ]);
        Permission::create([
            'name' => 'User Edit'
        ]);
        Permission::create([
            'name' => 'User Delete'
        ]);


        Permission::create([
            'name' => 'Jenis Index'
        ]);
        Permission::create([
            'name' => 'Jenis Create'
        ]);
        Permission::create([
            'name' => 'Jenis Edit'
        ]);
        Permission::create([
            'name' => 'Jenis Delete'
        ]);


        Permission::create([
            'name' => 'Satuan Index'
        ]);
        Permission::create([
            'name' => 'Satuan Create'
        ]);
        Permission::create([
            'name' => 'Satuan Edit'
        ]);
        Permission::create([
            'name' => 'Satuan Delete'
        ]);


        Permission::create([
            'name' => 'Supplier Index'
        ]);
        Permission::create([
            'name' => 'Supplier Create'
        ]);
        Permission::create([
            'name' => 'Supplier Edit'
        ]);
        Permission::create([
            'name' => 'Supplier Delete'
        ]);
    }
}
