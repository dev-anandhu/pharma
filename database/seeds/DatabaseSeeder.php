<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        DB::table('users')->insert([
            [
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'type' => 1,
                'department' => NULL,
                'status' => true,
                'created_at' => date("Y-m-d H:i:s")
            ],
            [
                'first_name' => 'Sales',
                'last_name' => 'Department',
                'email' => 'sales@gmail.com',
                'password' => Hash::make('password'),
                'type' => 2,
                'department' => 1,
                'status' => true,
                'created_at' => date("Y-m-d H:i:s")
            ],
            [
                'first_name' => 'Quality',
                'last_name' => 'Department',
                'email' => 'quality@gmail.com',
                'password' => Hash::make('password'),
                'type' => 2,
                'department' => 2,
                'status' => true,
                'created_at' => date("Y-m-d H:i:s")
            ],
            [
                'first_name' => 'Anandhu',
                'last_name' => 'V R',
                'email' => 'anandhu@gmail.com',
                'password' => Hash::make('password'),
                'type' => 3,
                'department' => 1,
                'status' => true,
                'created_at' => date("Y-m-d H:i:s")
            ],
            [
                'first_name' => 'Arun',
                'last_name' => 'K S',
                'email' => 'arun@gmail.com',
                'password' => Hash::make('password'),
                'type' => 3,
                'department' => 2,
                'status' => true,
                'created_at' => date("Y-m-d H:i:s")
            ]        
        ]
    );
    }
}
