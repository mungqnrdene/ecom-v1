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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            // Аль захиалгын дэд зүйлс (жишээ: ORD-001-т 2 зүйл)
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            // Аль барааг хэрэглэгч авахаар хүссэн
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            // Ихэнх үед product_variant_id байна (өнгө, хэмжээ өмнөх бүртгэл)
            $table->foreignId('product_variant_id')->nullable()->constrained('product_variants')->onDelete('set null');
            // Захиалгын үед барааны нэр (үнэлгээ өөрчлөгдсөн байж болно)
            $table->string('product_name');
            // Захиалгын үед үнэ (түүний үед хэдэн үнэтэй байсан)
            $table->decimal('price_at_purchase', 10, 2);
            // Хэмжээ (хэдэн ширхэг)
            $table->integer('quantity');
            // Нийт (price × quantity)
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
