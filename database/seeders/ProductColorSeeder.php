<?php

namespace Database\Seeders;

use App\Models\ProductColor;
use Illuminate\Database\Seeder;

class ProductColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product_color = [
            [
                'color_code' => 'black',
                'color_name' => '000000',
            ],
            [
                'color_code' => 'silver',
                'color_name' => 'C0C0C0',
            ],
            [
                'color_code' => 'gray',
                'color_name' => '808080',
            ],
            [
                'color_code' => 'white',
                'color_name' => 'FFFFFF',
            ],
            [
                'color_code' => 'maroon',
                'color_name' => '800000',
            ],
            [
                'color_code' => 'red',
                'color_name' => 'FF0000',
            ],
            [
                'color_code' => 'purple',
                'color_name' => '800080',
            ],
            [
                'color_code' => 'fuchsia',
                'color_name' => 'FF00FF',
            ],
            [
                'color_code' => 'green',
                'color_name' => '008000',
            ],
            [
                'color_code' => 'lime',
                'color_name' => '00FF00',
            ],
            [
                'color_code' => 'olive',
                'color_name' => '808000',
            ],
            [
                'color_code' => 'yellow',
                'color_name' => 'FFFF00',
            ],
            [
                'color_code' => 'navy',
                'color_name' => '000080',
            ],
            [
                'color_code' => 'blue',
                'color_name' => '0000FF',
            ],
            [
                'color_code' => 'teal',
                'color_name' => '008080',
            ],
            [
                'color_code' => 'aqua',
                'color_name' => '00FFFF',
            ],
        ];

        foreach ($product_color as $key => $value) {
            ProductColor::create($value);
        }
    }
}
