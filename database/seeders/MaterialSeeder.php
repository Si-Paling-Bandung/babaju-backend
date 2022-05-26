<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $material = [
            [
                'material_name' => 'Katun',
            ],
            [
                'material_name' => 'Linen',
            ],
            [
                'material_name' => 'Denim',
            ],
            [
                'material_name' => 'Drill',
            ],
        ];

        foreach ($material as $key => $value) {
            Material::create($value);
        }
    }
}
