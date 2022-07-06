<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Type extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type')->insert([
            [
                'name' => 'MSI CENTER PRO',
                'codename' => 'MSI-X99',
                'brand_id' => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'MSI ZYTEX TR',
                'codename' => 'MSI-Zq9o',
                'brand_id' => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'ACER ALIEN',
                'codename' => 'AC-X99',
                'brand_id' => 2,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
        ]);
    }
}