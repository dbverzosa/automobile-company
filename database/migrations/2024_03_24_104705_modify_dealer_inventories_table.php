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
        Schema::table('dealer_inventories', function (Blueprint $table) {
            $table->dropColumn('date_purchased');
            $table->boolean('post')->default(false);
            $table->boolean('trend')->default(false);
            $table->integer('new_price');
            $table->string('details')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dealer_inventories', function (Blueprint $table) {
            $table->date('date_purchased')->nullable();
            $table->dropColumn('post');
            $table->dropColumn('trend');
            $table->dropColumn('new_price');
            $table->dropColumn('details');
        });
    }
};
