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
        Schema::create('fuzzyfikasi', function (Blueprint $table) {
            $table->id();
            $table->string('mspenjualan', 50);  // miu sedikit penjualan
            $table->string('mbpenjualan', 50);  // miu banyak penjualan
            $table->string('mbrijek', 50);      // miu banyak rijek
            $table->string('msrijek', 50);      // miu sedikit rijek
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuzzyfikasi');
    }
};
