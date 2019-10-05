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
        $loops = ['menu tf', 'menu add'];
        
        // $per = [1,2];

        // foreach ($per as $mis) {
            foreach ($loops as $loop) {
                Permission::create([
                    'name' => $loop,
                    'permission_id' => 1,
                    'slug' => Str::slug($loop)
                ]);

                // Permission::create([
                //     'name' => $loop,
                //     'permission_id' => 2
                //     'slug' => Str::slug($loop)
                // ]);
            // }
        }
    }
}
