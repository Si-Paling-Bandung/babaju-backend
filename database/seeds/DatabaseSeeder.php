<?php

use App\Models\Config;
use App\Models\Instance;
use App\Models\LocalOfficial;
use App\Models\RegionalDevice;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'email' => 'admin@gmail.com',
                'role' => 'admin',
                'role' => 'admin',
                'password' => bcrypt('password'),
            ],
            [
                'first_name' => 'user',
                'last_name' => 'user',
                'email' => 'user@gmail.com',
                'role' => 'uuser',
                'password' => bcrypt('password'),
            ],
        ];

        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
