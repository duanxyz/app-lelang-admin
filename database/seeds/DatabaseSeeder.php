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
            'username' => 'admin',
            'email' => 'admin@lelang.dev',
            'password' => Hash::make('lelang'),
        ]);
        $manager = User::create([
            'username' => 'manager',
            'email' => 'manager@lelang.dev',
            'password' => Hash::make('lelang'),
        ]);
        $editor = User::create([
            'username' => 'pegawai',
            'email' => 'pegawai@lelang.dev',
            'password' => Hash::make('lelang'),
        ]);

        $category = [
            'elektronik',
            'perhiasan',
            'sertifikat',
            'kendaraan',
        ];
        for ($i = 0; $i < 4; $i++) {
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

        $admin->syncRoles($adminRole);
        $manager->syncRoles($managerRole);
        $editor->syncRoles($editorRole);

        //$this->call(UsersTableSeeder::class);
        $this->call(MemberTableSeeder::class);
        $this->call(ItemTableSeeder::class);
    }
}
