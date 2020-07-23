<?php

use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            [
                'name' => 'Sales',
                'created_at' => date("Y-m-d H:i:s")
            ],
            [
                'name' => 'Quality',
                'created_at' => date("Y-m-d H:i:s")
            ],
        ]);
    }
}
