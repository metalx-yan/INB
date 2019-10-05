<?php

use Illuminate\Database\Seeder;
use App\Models\Permission;

class ParentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $loops = ['debit', 'funding'];
        foreach ($loops as $loop) {
            Permission::create([
                'name' => $loop,
                'slug' => Str::slug($loop)
            ]);
        }
    }
}
