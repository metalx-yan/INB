<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $loop = ['saving', 'deposito'];

        foreach ($loop as $l) {
            Category::create([
                'name' => $l
            ]);
        }
    }
}
