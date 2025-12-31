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
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            // Аль барааны зурагт хамаарагдаж байгаа
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            // Зургийн URL/path
            $table->string('image_path');
            // Үндсэн зураг эсэх (гэрлийн хичээл нүүл үзүүлэх)
            $table->boolean('is_primary')->default(false);
            // Дараалал (хэзээ үзүүлэх)
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
