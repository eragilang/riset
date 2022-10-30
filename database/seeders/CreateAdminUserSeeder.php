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
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'alamat' => '',
            'password' => 'admin',
            'status' => 1,
        ]);

        $dosen = User::create([
            'name' => 'Dosen',
            'email' => 'dosen@gmail.com',
            'alamat' => '',
            'password' => 'dosen',
            'status' => 1,
        ]);

        $user = User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'alamat' => '',
            'password' => 'user',
            'status' => 1,
        ]);

        $this->command->info("User Berhasil dibuat");

        $adminRole = Role::create(['name' => 'admin']);
        $dosenRole = Role::create(['name' => 'dosen']);
        $userRole = Role::create(['name' => 'user']);

        $permissions = Permission::pluck('id','id')->all();

        $permissionDosen = Permission::where('name', 'like', '%hewan.%')->get()->pluck('id', 'id');

        $adminRole->syncPermissions($permissions);
        $dosenRole->syncPermissions($permissionDosen);

        $admin->assignRole([$adminRole->id]);
        $dosen->assignRole([$dosenRole->id]);
        $user->assignRole([$userRole->id]);

        $this->command->info("Role sudah di tambahkan kepada user.");
    }
}
