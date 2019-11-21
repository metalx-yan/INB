<?php

use Illuminate\Database\Seeder;
use App\Models\AccType;

class AccTypeTableSeeder extends Seeder
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
            AccType::create([
                'acc' => $faker->postcode. '-'. $faker->buildingNumber,
                ]);
            }
    }
}
