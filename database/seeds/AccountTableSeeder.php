<?php

use Illuminate\Database\Seeder;
use App\Models\Account;

class AccountTableSeeder extends Seeder
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
            Account::create([
            'number' => $faker->randomNumber,
            'cif_key' => $faker->unixTime,
            'cif_created_at' => $faker->date,
            'account_open' => $faker->date,
            'average' => 98392,
            'current_balance' => 82328,
            'currency' => $faker->currencyCode,
            'birth_date' => $faker->date,
            'handphone' => $faker->phoneNumber,
            'adrress' => $faker->address,
            'company' => $faker->company,
            'occupation' => $faker->country,
            'status' => 'dormant',
            'monthly_income' => 213656.23,
            'gender' => 1,
            'work_phone' => $faker->phoneNumber,
            'home_phone' => $faker->phoneNumber,
            'workplace_name' => $faker->streetName,
            'workplace_address' => $faker->streetAddress,
            'email' => $faker->email,
            'identity' => $faker->randomNumber,
            'place_of_birth' => $faker->state,
            'product_id' => 1,
            'branch_id' => 2,
            ]);
        }
    }
}
