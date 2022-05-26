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
                'color_name' => 'black',
                'color_code' => '000000',
            ],
            [
                'color_name' => 'silver',
                'color_code' => 'C0C0C0',
            ],
            [
                'color_name' => 'gray',
                'color_code' => '808080',
            ],
            [
                'color_name' => 'white',
                'color_code' => 'FFFFFF',
            ],
            [
                'color_name' => 'maroon',
                'color_code' => '800000',
            ],
            [
                'color_name' => 'red',
                'color_code' => 'FF0000',
            ],
            [
                'color_name' => 'purple',
                'color_code' => '800080',
            ],
            [
                'color_name' => 'fuchsia',
                'color_code' => 'FF00FF',
            ],
            [
                'color_name' => 'green',
                'color_code' => '008000',
            ],
            [
                'color_name' => 'lime',
                'color_code' => '00FF00',
            ],
            [
                'color_name' => 'olive',
                'color_code' => '808000',
            ],
            [
                'color_name' => 'yellow',
                'color_code' => 'FFFF00',
            ],
            [
                'color_name' => 'navy',
                'color_code' => '000080',
            ],
            [
                'color_name' => 'blue',
                'color_code' => '0000FF',
            ],
            [
                'color_name' => 'teal',
                'color_code' => '008080',
            ],
            [
                'color_name' => 'aqua',
                'color_code' => '00FFFF',
            ],
        ];

        foreach ($product_color as $key => $value) {
            ProductColor::create($value);
        }
    }
}
