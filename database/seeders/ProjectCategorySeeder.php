<?php

namespace Database\Seeders;

use App\Models\ProjectCategory;
use Illuminate\Database\Seeder;

class ProjectCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $project_category = [
            [
                'name' => 'Sosial',
            ],
            [
                'name' => 'Recycle',
            ],
            [
                'name' => 'Campaign',
            ],
        ];

        foreach ($project_category as $key => $value) {
            ProjectCategory::create($value);
        }
    }
}
