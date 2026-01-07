<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update order status enum to include 'paid' and 'failed'
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'processing', 'paid', 'shipped', 'delivered', 'cancelled', 'failed', 'refunded') DEFAULT 'pending'");

        // Add payment_method column
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('payment_method', ['card', 'qpay', 'cash_on_delivery'])->nullable()->after('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('payment_method');
        });

        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending'");
    }
};
