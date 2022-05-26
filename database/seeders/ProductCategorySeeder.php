<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product_category = [
            [
                'name' => 'Baju',
            ],
            [
                'name' => 'Kemeja',
            ],
            [
                'name' => 'Kaus',
            ],
            [
                'name' => 'Jubah',
            ],
            [
                'name' => 'Celana',
            ],
            [
                'name' => 'Baju',
            ],
            [
                'name' => 'Rok',
            ],
            [
                'name' => 'Sorjan',
            ],
            [
                'name' => 'Pakaian Dalam',
            ],
        ];

        foreach ($product_category as $key => $value) {
            ProductCategory::create($value);
        }
    }
}
