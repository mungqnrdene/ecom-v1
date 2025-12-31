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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // Захиалга хэнийх (нэвтэрсэн хэрэглэгч)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // Захиалгын дугаар (жишээ: ORD-2025-001)
            $table->string('order_number')->unique();
            // Захиалгын статус: pending (хүлээх), processing, shipped, delivered, cancelled
            $table->enum('status', ['pending', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending');
            // Төлөлтийн статус: pending (төлөлгүй), paid (төлөлт), refunded (буцаасан)
            $table->enum('payment_status', ['pending', 'paid', 'refunded'])->default('pending');
            // Нийт үнэ (татвар, агуулахын үнэ гүй)
            $table->decimal('subtotal', 10, 2);
            // Хүргүүлэх өртөг
            $table->decimal('shipping_cost', 10, 2)->default(0);
            // Татвар (эсэл 10% юм)
            $table->decimal('tax', 10, 2)->default(0);
            // Нийт эцсийн үнэ (subtotal + shipping + tax)
            $table->decimal('total_amount', 10, 2);
            // Хүргүүлэлтийн хаяг (авлага, байшин, гудамж)
            $table->text('shipping_address');
            // Холбох утас
            $table->string('phone')->nullable();
            // Баримтлалын тэмдэглэл (хүргүүлэлтийн чиглэлүүд)
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
