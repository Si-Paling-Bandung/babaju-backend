<?php

namespace Database\Seeders;

use App\Models\ProductSize;
use Illuminate\Database\Seeder;

class ProductSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product_size = [
            [
                'size' => 'S',
            ],
            [
                'size' => 'M',
            ],
            [
                'size' => 'L',
            ],
            [
                'size' => 'XL',
            ],
        ];

        foreach ($product_size as $key => $value) {
            ProductSize::create($value);
        }
    }
}
