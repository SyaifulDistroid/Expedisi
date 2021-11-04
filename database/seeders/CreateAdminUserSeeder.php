<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
        	'name' => 'Super Admin',
        	'email' => 'admin@gmail.com',
        	'password' => bcrypt('123456'),
            'cabang' => 'All'
        ]);

        $role = Role::create(['name' => 'Admin']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);

        $user = User::create([
            'name' => 'user1',
            'email' => 'user1@gmail.com',
            'password' => bcrypt('123456'),
            'cabang' => 'Cirebon'
        ]);

//        $role = Role::create(['name' => 'Admin']);
//
//        $permissions = Permission::pluck('id','id')->all();
//
//        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
