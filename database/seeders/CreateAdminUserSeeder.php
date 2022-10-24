<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
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
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'alamat' => '',
            'password' => 'admin',
            'status' => 1,
        ]);

        // $users = User::factory()
        //         ->count(20)
        //         ->sequence(fn ($sequence) => ['name' => 'Name '.$sequence->index])
        //         ->create();


        $adminRole = Role::create(['name' => 'admin']);
        $dosenRole = Role::create(['name' => 'dosen']);
        $userRole = Role::create(['name' => 'user']);

        $permissions = Permission::pluck('id','id')->all();

        $adminRole->syncPermissions($permissions);

        $user->assignRole([$adminRole->id]);
    }
}
