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
        Schema::table('orders', function (Blueprint $table) {
            // Change payment_method enum to remove 'qpay'
            $table->enum('payment_method', ['card', 'cash_on_delivery'])->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Restore original enum with 'qpay'
            $table->enum('payment_method', ['card', 'qpay', 'cash_on_delivery'])->nullable()->change();
        });
    }
};
