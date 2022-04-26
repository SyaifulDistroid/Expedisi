<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
           'role-list',
           'role-create',
           'role-edit',
           'role-delete',
           'product-list',
           'product-create',
           'product-edit',
           'product-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'transaction-create',
            'transaction-edit',
            'transaction-delete',
            'transaction-list',
            'print-create',
            'print-edit',
            'print-delete',
            'print-list',
            'report-create',
            'report-edit',
            'report-delete',
            'report-list',
        ];

        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}
