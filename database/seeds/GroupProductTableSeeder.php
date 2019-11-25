<?php

use Illuminate\Database\Seeder;
use App\Models\GroupProduct;

class GroupProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
            GroupProduct::create([
                'name' => 'tapma',
                'type_product_id' => 1
            ]);

            GroupProduct::create([
                'name' => 'tapma pintar',
                'type_product_id' => 1
            ]);

            GroupProduct::create([
                'name' => 'tapma cerdas',
                'type_product_id' => 1
            ]);

            GroupProduct::create([
                'name' => 'tappa',
                'type_product_id' => 2
            ]);

            GroupProduct::create([
                'name' => 'tappa pintar',
                'type_product_id' => 2
            ]);

            GroupProduct::create([
                'name' => 'tappa cerdas',
                'type_product_id' => 2
            ]);
        
        
    }
}
