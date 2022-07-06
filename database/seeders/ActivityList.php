<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivityList extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('activity_list')->insert([
            [
                'name' => 'Melakukan login',
                'type_id' => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'Melakukan logout',
                'type_id' => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'Menambahkan pengguna baru',
                'type_id' => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'Mengubah data pengguna',
                'type_id' => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'Menghapus data pengguna',
                'type_id' => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'Mengembalikan data pengguna',
                'type_id' => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'Menghapus data pengguna yang telah dihapus',
                'type_id' => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'Menghapus semua data pengguna yang telah dihapus',
                'type_id' => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'Mengubah password pengguna',
                'type_id' => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'Menambahkan brand baru',
                'type_id' => 2,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'Mengubah data brand',
                'type_id' => 2,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'Menghapus data brand',
                'type_id' => 2,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'Mengembalikan data brand',
                'type_id' => 2,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'Menghapus data brand yang telah dihapus',
                'type_id' => 2,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'Menghapus semua data brand yang telah dihapus',
                'type_id' => 2,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'Menambahkan sparepart baru',
                'type_id' => 3,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'Mengubah data sparepart',
                'type_id' => 3,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'Menghapus data sparepart',
                'type_id' => 3,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'Mengembalikan data sparepart',
                'type_id' => 3,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'Menghapus data sparepart yang telah dihapus',
                'type_id' => 3,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'Menghapus semua data sparepart yang telah dihapus',
                'type_id' => 3,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'Menambahkan hardware baru',
                'type_id' => 4,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'Mengubah data hardware',
                'type_id' => 4,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'Menghapus data hardware',
                'type_id' => 4,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'Mengembalikan data hardware',
                'type_id' => 4,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'Menghapus data hardware yang telah dihapus',
                'type_id' => 4,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'Menghapus semua data hardware yang telah dihapus',
                'type_id' => 4,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'Menambahkan tipe baru',
                'type_id' => 5,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'Mengubah data tipe',
                'type_id' => 5,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'Menghapus data tipe',
                'type_id' => 5,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'Mengembalikan data tipe',
                'type_id' => 5,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'Menghapus data tipe yang telah dihapus',
                'type_id' => 5,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'Menghapus semua data tipe yang telah dihapus',
                'type_id' => 5,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
        ]);
    }
}