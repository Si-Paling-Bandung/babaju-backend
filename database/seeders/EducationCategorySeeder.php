<?php

namespace Database\Seeders;

use App\Models\EducationCategory;
use Illuminate\Database\Seeder;

class EducationCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $education_category = [
            [
                'name' => 'Education',
            ],
        ];

        foreach ($education_category as $key => $value) {
            EducationCategory::create($value);
        }
    }
}
