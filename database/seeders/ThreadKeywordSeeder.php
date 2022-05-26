<?php

namespace Database\Seeders;

use App\Models\ThreadKeyword;
use Illuminate\Database\Seeder;

class ThreadKeywordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $thread_keyword = [
            [
                'name' => 'womens clothes',
            ],
            [
                'name' => '80s fashion',
            ],
            [
                'name' => 'fashion designing',
            ],
            [
                'name' => 'fashion designer',
            ],
            [
                'name' => 'fashion blog',
            ],
            [
                'name' => 'mens fashion',
            ],
            [
                'name' => 'fashion designer games',
            ],
            [
                'name' => 'fashion house',
            ],
            [
                'name' => 'fashion designer',
            ],
            [
                'name' => 'fashion show',
            ],
            [
                'name' => 'fashion week',
            ],
        ];

        foreach ($thread_keyword as $key => $value) {
            ThreadKeyword::create($value);
        }
    }
}
