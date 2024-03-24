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
        Schema::create('manufacturer_vehicle_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained('manufacturer_vehicles');
            $table->foreignId('dealer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('manufacturer_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('date_purchased');
            $table->decimal('sale_price', 10, 2);
            $table->integer('quantity_sold');
            $table->decimal('total_price', 10, 2);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manufacturer_vehicle_sales');
    }
};
