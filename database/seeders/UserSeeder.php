<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB as FacadesDB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        FacadesDB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt ('admin123'),
                'role' => 'admin',
                'region' => 'CARAGA',
                'phone_number' => '09193806117',
                'city' => 'Butuan',
                'address' => 'Taguibo'
            ],
            [
                'name' => 'Supplier',
                'email' => 'supplier@gmail.com',
                'password' => bcrypt ('supplier123'),
                'role' => 'supplier',
                'phone_number' => '09193806116',
                'region' => 'IV',
                'city' => 'Quezon',
                'address' => 'Greenhills'
            ],
            [
                'name' => 'Manufacturer',
                'email' => 'manufacturer@gmail.com',
                'password' => bcrypt ('manufacturer123'),
                'role' => 'manufacturer',
                'phone_number' => '09193806115',
                'region' => 'VII',
                'city' => 'Cebu',
                'address' => 'Minglanilla'
            ],
            [
                'name' => 'Dealer',
                'email' => 'dealer@gmail.com',
                'password' => bcrypt ('dealer123'),
                'role' => 'dealer',
                'phone_number' => '09193806114',
                'region' => 'CARAGA',
                'city' => 'Butuan',
                'address' => 'Ampayon'
            ],
            [
                'name' => 'Customer',
                'email' => 'customer@gmail.com',
                'password' => bcrypt ('customer123'),
                'role' => 'customer',
                'phone_number' => '09193806113',
                'region' => 'NCR',
                'city' => 'Taguig',
                'address' => 'Fort Bonifacio'
            ]
            ]);
    }
}
