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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            // Сагс кэнийх (нэвтэрсэн эсэхээ)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // Сагсанд нэмэгдсэн нийт эд (заримдаа 0 байж болно)
            $table->integer('total_items')->default(0);
            // Сагсанд байгаа нийт үнэ (кэш)
            $table->decimal('total_price', 10, 2)->default(0);
            // Сагсыг цэвэрлэх хугацаа (1 сарын дараа автоматаар арилгах)
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
