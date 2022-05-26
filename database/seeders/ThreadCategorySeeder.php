<?php

namespace Database\Seeders;

use App\Models\ThreadCategory;
use Illuminate\Database\Seeder;

class ThreadCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $thread_category = [
            [
                'name' => 'Kerja Sama',
            ],
            [
                'name' => 'Sewa',
            ],
            [
                'name' => 'Preferensi Bundle',
            ],
            [
                'name' => 'Reseller',
            ],
            [
                'name' => 'Sharing',
            ],
            [
                'name' => 'Trending',
            ],
        ];

        foreach ($thread_category as $key => $value) {
            ThreadCategory::create($value);
        }
    }
}
