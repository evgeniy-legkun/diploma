<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $admin = User::updateOrCreate(
            [
                'email' => 'admin@admin.com'
            ],
            [
               'name' => 'admin',
               'email' => 'admin@admin.com',
               'password' => bcrypt('123456'),
               'role' => User::ROLE_ADMINISTRATOR,
            ]
        );

        // $this->call(UsersTableSeeder::class);
    }
}
