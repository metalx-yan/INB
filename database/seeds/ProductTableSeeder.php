<?php

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $loop = ['product-saving-1', 'product-saving-2', 'product-saving-3'];
        $acc = [2321, 4332, 4355];

        foreach (array_combine($loop, $acc) as $l => $a) {
            Product::create([
                'account_type' => $a,
                'sub_category' => 12,
                'name' => $l,
                'category_id' => 1,
                'group_product_id' => 2,
                'acc_type_id' => 1
            ]);
        }
    }
}
