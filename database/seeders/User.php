<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class User extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => '1',
                'name' => 'Wreative',
                'email' => 'contact@wreative.com',
                'username' => 'admin',
                'password' => Hash::make('admin'),
                'is_admin' => true,
                'updated_by' => 'Wreative',
                'created_by' => 'Wreative',
                'deleted_by' => 'Wreative',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
        ]);
    }
}