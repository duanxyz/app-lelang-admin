<?php

use App\Laravue\Models\Bank;
use App\Laravue\Models\Category;
use App\Laravue\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Laravue\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'username' => 'Admin',
            'email' => 'admin@laravue.dev',
            'password' => Hash::make('laravue'),
        ]);
        $manager = User::create([
            'username' => 'Manager',
            'email' => 'manager@laravue.dev',
            'password' => Hash::make('laravue'),
        ]);
        $editor = User::create([
            'username' => 'Editor',
            'email' => 'editor@laravue.dev',
            'password' => Hash::make('laravue'),
        ]);
        $user = User::create([
            'username' => 'User',
            'email' => 'user@laravue.dev',
            'password' => Hash::make('laravue'),
        ]);
        $visitor = User::create([
            'username' => 'Visitor',
            'email' => 'visitor@laravue.dev',
            'password' => Hash::make('laravue'),
        ]);

        $category = [
            'elektronik',
            'emas',
            'pertanian',
            'perikanan',
            'sertifikat',
            'kendaraan',
        ];
        for ($i = 0; $i < 6; $i++) {
            Category::create([
                'category_name' => $category[$i],
            ]);
        }

        Bank::create([
            'bank_name' => 'BNI',
            'account_number' => '129321',
            'name' => 'Muhammad Ridwan',
        ]);

        $adminRole = Role::findByName(\App\Laravue\Acl::ROLE_ADMIN);
        $managerRole = Role::findByName(\App\Laravue\Acl::ROLE_MANAGER);
        $editorRole = Role::findByName(\App\Laravue\Acl::ROLE_EDITOR);
        $userRole = Role::findByName(\App\Laravue\Acl::ROLE_USER);
        $visitorRole = Role::findByName(\App\Laravue\Acl::ROLE_VISITOR);
        $admin->syncRoles($adminRole);
        $manager->syncRoles($managerRole);
        $editor->syncRoles($editorRole);
        $user->syncRoles($userRole);
        $visitor->syncRoles($visitorRole);
        //$this->call(UsersTableSeeder::class);
        $this->call(MemberTableSeeder::class);
        $this->call(ItemTableSeeder::class);
    }
}
