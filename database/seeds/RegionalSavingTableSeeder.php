<?php

use Illuminate\Database\Seeder;
use App\Models\RegionalSaving;

class RegionalSavingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i=0; $i < 10; $i++) { 
            RegionalSaving::create([

            'date' => $faker->date,
            'number_account' => $faker->unixTime,
            'balance' => $faker->unixTime,
            'product_id' => 2,
            'region_id' => 3,
            'type_product_id' => 1,
            'group_product_id' => 2
            ]);
        }
    }
}
