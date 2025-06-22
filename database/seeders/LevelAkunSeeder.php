<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelAkunSeeder extends Seeder
{
    public function run()
    {
        // Level akun: Admin
        DB::table('level_akun')->insert([
            'id_level' =>1,
            'nama_level' => 'Admin',
            'deskripsi' => 'sebagai admin'
        ]);

        // Level akun: Customer
        DB::table('level_akun')->insert([
            'id_level' => 2,
            'nama_level' => 'Customer',
            'deskripsi' => 'sebagai cust'
        ]);
    }
}
