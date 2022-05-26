<?php

namespace Database\Seeders;

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
        $this->call([
            UserSeeder::class,
            MaterialSeeder::class,

            ProductSizeSeeder::class,
            ProductColorSeeder::class,
            ProductCategorySeeder::class,

            ThreadCategorySeeder::class,
            ThreadKeywordSeeder::class,

            ProjectCategorySeeder::class,

            EducationCategorySeeder::class,
        ]);
    }
}
