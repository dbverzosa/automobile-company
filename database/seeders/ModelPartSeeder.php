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
                'user_id' => 8,
                'model_name' => 'Toyota Corolla',
                'image' => 'modelparts_images/toyota.jpeg',
                'price' => 1,
                'quantity' => 10,
                'date_supplied' => '2023-01-01',
                'is_available' => true,
            ],
            [
                'user_id' => 8,
                'model_name' => 'Honda Civic',
                'image' => 'modelparts_images/hondacivic.jpeg',
                'price' => 1,
                'quantity' => 5,
                'date_supplied' => '2023-02-02',
                'is_available' => false,
            ],
            [
                'user_id' => 8,
                'model_name' => 'Ford Mustang',
                'image' => 'modelparts_images/fordmustang.jpg',
                'price' => 1,
                'quantity' => 8,
                'date_supplied' => '2023-03-03',
                'is_available' => false,
            ],
            [
                'user_id' => 8,
                'model_name' => 'Chevrolet Camaro',
                'image' => 'modelparts_images/chevroletcamaro.jpg',
                'price' => 1,
                'quantity' => 4,
                'date_supplied' => '2023-04-04',
                'is_available' => true,
            ],
            [
                'user_id' => 8,
                'model_name' => 'Toyota Corolla',
                'image' => 'modelparts_images/toyota.jpeg',
                'price' => 1,
                'quantity' => 10,
                'date_supplied' => '2023-01-01',
                'is_available' => true,
            ],
            [
                'user_id' => 8,
                'model_name' => 'Honda Civic',
                'image' => 'modelparts_images/hondacivic.jpeg',
                'price' => 1,
                'quantity' => 5,
                'date_supplied' => '2023-02-02',
                'is_available' => false,
            ],
            [
                'user_id' => 8,
                'model_name' => 'Ford Mustang',
                'image' => 'modelparts_images/fordmustang.jpg',
                'price' => 1,
                'quantity' => 8,
                'date_supplied' => '2023-03-03',
                'is_available' => false,
            ],
            [
                'user_id' => 8,
                'model_name' => 'Chevrolet Camaro',
                'image' => 'modelparts_images/chevroletcamaro.jpg',
                'price' => 1,
                'quantity' => 4,
                'date_supplied' => '2023-04-04',
                'is_available' => true,
            ],
            [
                'user_id' => 8,
                'model_name' => 'Toyota Corolla',
                'image' => 'modelparts_images/toyota.jpeg',
                'price' => 1,
                'quantity' => 10,
                'date_supplied' => '2023-01-01',
                'is_available' => true,
            ],
            [
                'user_id' => 8,
                'model_name' => 'Honda Civic',
                'image' => 'modelparts_images/hondacivic.jpeg',
                'price' => 1,
                'quantity' => 5,
                'date_supplied' => '2023-02-02',
                'is_available' => false,
            ],
            [
                'user_id' => 8,
                'model_name' => 'Ford Mustang',
                'image' => 'modelparts_images/fordmustang.jpg',
                'price' => 1,
                'quantity' => 8,
                'date_supplied' => '2023-03-03',
                'is_available' => false,
            ],
            [
                'user_id' => 8,
                'model_name' => 'Chevrolet Camaro',
                'image' => 'modelparts_images/chevroletcamaro.jpg',
                'price' => 1,
                'quantity' => 4,
                'date_supplied' => '2023-04-04',
                'is_available' => true,
            ],
            [
                'user_id' => 8,
                'model_name' => 'Toyota Corolla',
                'image' => 'modelparts_images/toyota.jpeg',
                'price' => 1,
                'quantity' => 10,
                'date_supplied' => '2023-01-01',
                'is_available' => true,
            ],
            [
                'user_id' => 8,
                'model_name' => 'Honda Civic',
                'image' => 'modelparts_images/hondacivic.jpeg',
                'price' => 1,
                'quantity' => 5,
                'date_supplied' => '2023-02-02',
                'is_available' => false,
            ],
            [
                'user_id' => 8,
                'model_name' => 'Ford Mustang',
                'image' => 'modelparts_images/fordmustang.jpg',
                'price' => 1,
                'quantity' => 8,
                'date_supplied' => '2023-03-03',
                'is_available' => false,
            ],
            [
                'user_id' => 8,
                'model_name' => 'Chevrolet Camaro',
                'image' => 'modelparts_images/chevroletcamaro.jpg',
                'price' => 1,
                'quantity' => 4,
                'date_supplied' => '2023-04-04',
                'is_available' => true,
            ]
            ]);
    }
}
