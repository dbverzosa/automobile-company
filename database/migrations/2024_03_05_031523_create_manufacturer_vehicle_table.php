<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('manufacturer_vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('vin');
            $table->string('image');
            $table->string('brand');
            $table->string('model');
            $table->decimal('price', 10, 2);
            $table->string('manufacturing_plant')->nullable();
            $table->text('details')->nullable();
            $table->string('color')->nullable();
            $table->string('engine')->nullable();
            $table->string('transmission')->nullable();
            $table->foreignId('manufacturer_id')->constrained('users')->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manufacturer_vehicles');
    }
};
