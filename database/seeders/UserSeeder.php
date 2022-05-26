<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'role' => 'admin',
                'phone_number' => '1234',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'User',
                'email' => 'user@gmail.com',
                'role' => 'user',
                'phone_number' => '1235',
                'password' => bcrypt('password'),
            ],
        ];

        foreach ($user as $key => $value) {
            User::create($value);
        }

        $store = [
            [
                'id_user' => '1',
                'name' => 'Admin Store',
                'description' => 'Admin Store is Example Store',
                'born_date' => '2020-05-26',
                'email' => 'admin@gmail.com',
                'lat' => '-6.9654587434045725',
                'long' => '107.59847565745407',
                'whatsapp_number' => '1234',
            ],
            [
                'id_user' => '2',
                'name' => 'Udin Store',
                'description' => 'Admin Store is Example Store',
                'born_date' => '2020-05-26',
                'email' => 'user@gmail.com',
                'lat' => '-6.9654587434045725',
                'long' => '107.59847565745407',
                'whatsapp_number' => '1234',
            ],
        ];

        foreach ($store as $key => $value) {
            Store::create($value);
        }
    }
}
