<?php
// database/seeders/AkunSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AkunSeeder extends Seeder
{
    public function run()
    {
        // Admin default
        DB::table("akun")->insert([
            "id_akun" => "U001",
            "id_level" => 1,
            "name" => "cici",
            "email" => "admin@gmail.com",
            "phone" => "081234567890", // Add phone field
            "password" => Hash::make("admin123"),
            "email_verified_at" => now(),
        ]);

        // Pengguna default
        DB::table("akun")->insert([
            "id_akun" =>"U002",
            "id_level" => 2, 
            "name" => "caca",
            "email" => "cust@gmail.com",
            "phone" => "081234567891", // Add phone field
            "password" => Hash::make("user123"),
            "email_verified_at" => now(),
        ]);
    }
}