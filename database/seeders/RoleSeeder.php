<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{

    $viewArticles = Permission::create(['name' => 'view articles']);
    $editArticles = Permission::create(['name' => 'edit articles']);
    $createArticles = Permission::create(['name' => 'create articles']);
    $deleteArticles = Permission::create(['name' => 'delete articles']);


    $admin = Role::create(['name' => 'admin']);
    $user = Role::create(['name' => 'user']);


    $admin->givePermissionTo([$viewArticles, $editArticles, $createArticles, $deleteArticles]);
    $user->givePermissionTo([$viewArticles,$createArticles]);


    $adminUser = User::create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => bcrypt('adminpassword')
    ]);

    $regularUser = User::create([
        'name' => 'John Doe',
        'email'=> 'johndoe@example.com',
        'password'=> bcrypt('Johndoe123')
    ]);

    $adminUser->assignRole('admin');
    $regularUser->assignRole('user');
}


}
