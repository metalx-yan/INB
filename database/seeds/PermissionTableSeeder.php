<?php

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
            Permission::create([
                'name' => 'funding',
                'slug' => 'funding'
            ]);
            
            $loops = ['form query', 'tabungan performance', 'key performance matrix'];
            
            foreach ($loops as $loop) {
                Permission::create([
                    'name' => $loop,
                    'permission_id' => 1,
                    'slug' => Str::slug($loop)
                ]);
            }
    }
}
