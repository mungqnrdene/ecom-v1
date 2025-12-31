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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            // Аль захиалгын төлөл
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            // Төлбөрийн хэлбэр: credit_card, debit_card, bank_transfer, cash, mobile_wallet
            $table->enum('payment_method', ['credit_card', 'debit_card', 'bank_transfer', 'cash', 'mobile_wallet']);
            // Төлбөрийн статус: pending (хүлээх), completed (дүүрэн), failed (сүл), refunded (буцаасан)
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');
            // Төлөлтийн дүн
            $table->decimal('amount', 10, 2);
            // Гадаад төлбөрийн систем ID (жишээ: Stripe, үйчүүдийн ID)
            $table->string('transaction_id')->nullable()->unique();
            // Бэлэг өгөхийн өмнөх баримт
            $table->string('reference_number')->nullable();
            // Төлбөрийн үйлдэлийг гүйцэтгэсэн админ (зөвхөн ручной төлбөрийн хүүхэл)
            $table->foreignId('admin_id')->nullable()->constrained('admins')->onDelete('set null');
            // Үйлдлийн нарийн мэдээлэл (ямар алдаа гарсан юм)
            $table->text('response_data')->nullable();
            // Төлбөрийн хугацаа
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
