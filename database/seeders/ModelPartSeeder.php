<?php

namespace Database\Seeders;

use App\Models\ModelParts;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB as FacadesDB;

class ModelPartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        FacadesDB::table('model_parts')->insert([
            [
                'user_id' => 2,
                'model_name' => 'Honda Civic',
                'image' => 'modelparts_images/hondacivic.jpeg',
                'price' => 2,
                'quantity' => 5,
                'date_supplied' => '2023-02-02',
                'is_available' => true,
            ],
            [
                'user_id' => 2,
                'model_name' => 'Honda Civic',
                'image' => 'modelparts_images/hondacivic.jpeg',
                'price' => 2,
                'quantity' => 5,
                'date_supplied' => '2023-02-02',
                'is_available' => true,
            ]
            ]);
    }
}
