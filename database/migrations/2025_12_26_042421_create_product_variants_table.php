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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            // Аль барааны төрөлүүд (жишээ: iPhone 15 Pro - Blue 256GB)
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            // Төрлийн нэр (жишээ: "Blue 256GB")
            $table->string('name');
            // SKU - бүтээгдэхүүний код (жишээ: IPHONE15-BLUE-256)
            $table->string('sku')->unique();
            // Нэмэлт үнэ (жишээ: өнгөний дүүд 10,000₮ илүү)
            $table->decimal('price_modifier', 10, 2)->default(0);
            // Агуулах дээрх сток тоо
            $table->integer('stock_quantity')->default(0);
            // Хүлээн авахгүй агуулахтай хэмжээ (жижигхэн сток)
            $table->integer('low_stock_threshold')->default(5);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
