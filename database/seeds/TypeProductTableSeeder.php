<?php

use Illuminate\Database\Seeder;
use App\Models\TypeProduct;

class TypeProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        
        for ($i=0; $i < 5; $i++) { 
            TypeProduct::create([
                'name' => $faker->creditCardType
            ]);
        }
    }
}
