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
        Schema::create('dealer_purchase_vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manufacturer_vehicle_id')->constrained('manufacturer_vehicles')->onDelete('cascade');
            $table->foreignId('dealer_id')->constrained('users')->onDelete('cascade');
            $table->date('date_purchased');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dealer_purchase_vehicles');
    }
};
