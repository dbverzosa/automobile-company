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
        Schema::create('customer_reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('dealer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('vehicle_id')->constrained('manufacturer_vehicles')->onDelete('cascade');
            $table->date('date_purchased')->nullable();
            $table->decimal('price', 10, 2);
            $table->date('date_delivered')->nullable();
            $table->boolean('is_pending')->default(true);
            $table->string('gender')->nullable();
            $table->integer('income')->nullable();
            $table->string('delivery_address')->nullable();
            $table->text('details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_reservations');
    }
};
