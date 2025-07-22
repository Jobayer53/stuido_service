<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('services')->insert([
            ['id' => 1, 'name' => 'Server Copy', 'cost' => 40.00, 'available' => 1, 'created_at' => '2025-07-12 07:07:51', 'updated_at' => '2025-07-12 04:17:56'],
            ['id' => 2, 'name' => 'Sign Copy', 'cost' => 10.00, 'available' => 1, 'created_at' => '2025-07-13 11:53:21', 'updated_at' => '2025-07-13 11:53:21'],
            ['id' => 3, 'name' => 'NID Pdf', 'cost' => 20.00, 'available' => 1, 'created_at' => '2025-07-13 15:10:17', 'updated_at' => '2025-07-15 03:31:36'],
            ['id' => 4, 'name' => 'Smart NID Pdf', 'cost' => 32000.00, 'available' => 1, 'created_at' => '2025-07-15 08:34:41', 'updated_at' => '2025-07-15 05:46:46'],
            ['id' => 5, 'name' => 'NID Pass Set', 'cost' => 22.00, 'available' => 1, 'created_at' => '2025-07-15 08:53:27', 'updated_at' => '2025-07-15 03:41:53'],
            ['id' => 6, 'name' => 'NID Form ', 'cost' => 25.00, 'available' => 1, 'created_at' => '2025-07-15 08:54:15', 'updated_at' => '2025-07-16 00:58:38'],
            ['id' => 7, 'name' => 'Robi/Airtel Biometric', 'cost' => 20.00, 'available' => 1, 'created_at' => '2025-07-16 09:18:02', 'updated_at' => '2025-07-16 05:38:44'],
            ['id' => 8, 'name' => 'Banlalink Biometric', 'cost' => 20.00, 'available' => 1, 'created_at' => '2025-07-16 09:18:49', 'updated_at' => '2025-07-16 05:38:50'],
            ['id' => 9, 'name' => 'Teletalk Biometric', 'cost' => 30.00, 'available' => 1, 'created_at' => null, 'updated_at' => '2025-07-16 05:38:56'],
            ['id' => 10, 'name' => 'Grameenphone Biometric', 'cost' => 20.00, 'available' => 1, 'created_at' => null, 'updated_at' => '2025-07-16 05:39:03'],
            ['id' => 11, 'name' => 'Lost NID', 'cost' => 200.00, 'available' => 1, 'created_at' => '2025-07-16 12:01:41', 'updated_at' => '2025-07-16 10:34:38'],
            ['id' => 12, 'name' => 'E-Passport', 'cost' => 100.00, 'available' => 1, 'created_at' => '2025-07-16 18:43:04', 'updated_at' => '2025-07-16 18:43:04'],
            ['id' => 13, 'name' => 'MRP-Passport', 'cost' => 80.00, 'available' => 1, 'created_at' => '2025-07-16 18:43:04', 'updated_at' => '2025-07-16 18:43:04'],
            ['id' => 14, 'name' => 'MRP to Server Copy', 'cost' => 180.00, 'available' => 1, 'created_at' => '2025-07-16 18:44:53', 'updated_at' => '2025-07-16 18:44:53'],
            ['id' => 15, 'name' => 'Number To Location', 'cost' => 400.00, 'available' => 0, 'created_at' => '2025-07-17 10:48:46', 'updated_at' => '2025-07-18 05:11:51'],
            ['id' => 16, 'name' => 'Call-list 3-Month', 'cost' => 900.00, 'available' => 1, 'created_at' => '2025-07-18 05:15:51', 'updated_at' => '2025-07-18 05:15:51'],
            ['id' => 17, 'name' => 'Sms-GP 1-Month', 'cost' => 500.00, 'available' => 1, 'created_at' => '2025-07-18 05:15:51', 'updated_at' => '2025-07-18 05:15:51'],
            ['id' => 18, 'name' => 'Sms-Banglalink 1-Month', 'cost' => 400.00, 'available' => 1, 'created_at' => '2025-07-18 05:17:19', 'updated_at' => '2025-07-18 05:17:19'],
            ['id' => 19, 'name' => 'IMEI to Active Number', 'cost' => 700.00, 'available' => 1, 'created_at' => '2025-07-18 09:19:21', 'updated_at' => '2025-07-18 09:19:21'],
            ['id' => 20, 'name' => 'NID to All Number', 'cost' => 430.00, 'available' => 1, 'created_at' => '2025-07-18 09:20:17', 'updated_at' => '2025-07-18 09:20:17'],
            ['id' => 21, 'name' => 'Number to IMEI', 'cost' => 400.00, 'available' => 1, 'created_at' => '2025-07-18 09:20:17', 'updated_at' => '2025-07-18 09:20:17'],
            ['id' => 22, 'name' => 'NID to All GP', 'cost' => 250.00, 'available' => 1, 'created_at' => '2025-07-18 09:20:17', 'updated_at' => '2025-07-18 09:20:17'],
            ['id' => 23, 'name' => 'NID to All Banglalink', 'cost' => 200.00, 'available' => 1, 'created_at' => '2025-07-18 09:20:17', 'updated_at' => '2025-07-18 09:20:17'],
            ['id' => 24, 'name' => 'IMEI Active Number + Biometric + Location', 'cost' => 1030.00, 'available' => 1, 'created_at' => '2025-07-18 09:20:17', 'updated_at' => '2025-07-18 09:20:17'],
            ['id' => 25, 'name' => 'Nagad Information', 'cost' => 1100.00, 'available' => 1, 'created_at' => '2025-07-18 18:32:27', 'updated_at' => '2025-07-18 18:32:27'],
            ['id' => 26, 'name' => 'Bikash Personal Info', 'cost' => 1150.00, 'available' => 1, 'created_at' => null, 'updated_at' => null],
            ['id' => 27, 'name' => 'Rocket Info', 'cost' => 1450.00, 'available' => 1, 'created_at' => null, 'updated_at' => null],
            ['id' => 28, 'name' => 'Nagad Personal 3-Month', 'cost' => 2500.00, 'available' => 1, 'created_at' => null, 'updated_at' => null],
            ['id' => 29, 'name' => 'Bikash Merchant Info', 'cost' => 1200.00, 'available' => 1, 'created_at' => null, 'updated_at' => null],
            ['id' => 30, 'name' => 'Bikash Agent Info', 'cost' => 1220.00, 'available' => 1, 'created_at' => null, 'updated_at' => null],
            ['id' => 32, 'name' => 'Zero Return', 'cost' => 500.00, 'available' => 1, 'created_at' => null, 'updated_at' => null],
            ['id' => 33, 'name' => 'Tin Certificate', 'cost' => 50.00, 'available' => 1, 'created_at' => null, 'updated_at' => null],
            ['id' => 34, 'name' => 'Land Service', 'cost' => 300.00, 'available' => 1, 'created_at' => null, 'updated_at' => null],
            ['id' => 35, 'name' => 'Birth Cert Before 2000', 'cost' => 1450.00, 'available' => 1, 'created_at' => null, 'updated_at' => null],
            ['id' => 36, 'name' => 'Birth Cert After 2000', 'cost' => 1950.00, 'available' => 1, 'created_at' => null, 'updated_at' => '2025-07-19 11:15:24'],
            ['id' => 37, 'name' => 'Birth+Death Registration ', 'cost' => 3700.00, 'available' => 1, 'created_at' => null, 'updated_at' => null],
            ['id' => 38, 'name' => 'lost Birth Certificate', 'cost' => 850.00, 'available' => 1, 'created_at' => null, 'updated_at' => null],
            ['id' => 39, 'name' => 'Rocket Statement 3-Month', 'cost' => 350.00, 'available' => 1, 'created_at' => null, 'updated_at' => null],
            ['id' => 40, 'name' => 'Nagad Agent Statement', 'cost' => 3700.00, 'available' => 1, 'created_at' => null, 'updated_at' => null],
            ['id' => 41, 'name' => 'Vaccine ', 'cost' => 75.00, 'available' => 1, 'created_at' => null, 'updated_at' => null],
            ['id' => 42, 'name' => 'Birth Certificate Number Change', 'cost' => 75.00, 'available' => 1, 'created_at' => null, 'updated_at' => null],
             ['id' => 43, 'name' => 'Call-list 6-Month', 'cost' => 400.00, 'available' => 1, 'created_at' => '2025-07-18 05:17:19', 'updated_at' => '2025-07-18 05:17:19'],
        ]);
    }
}
