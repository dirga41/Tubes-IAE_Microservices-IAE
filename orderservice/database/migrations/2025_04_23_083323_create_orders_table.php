<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('status')->default('pending');
            $table->decimal('total_price', 10, 2)->nullable();
            $table->timestamps();
            // Kolom product_id dan quantity telah dihapus dari sini
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
