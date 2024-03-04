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
        Schema::create('inventory_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('model_part_id')->constrained('model_parts')->onDelete('cascade');
            $table->integer('total_quantity')->default(0); 
            $table->integer('remaining_quantity')->default(0);
            $table->integer('sold_quantity')->default(0);
            $table->decimal('total_sales', 10, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_sales');
    }
};
