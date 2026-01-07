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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('period_type'); // '10_days' or 'monthly'
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('new_users_count')->default(0);
            $table->integer('total_orders_count')->default(0);
            $table->decimal('total_sales_amount', 15, 2)->default(0);
            $table->integer('refunded_orders_count')->default(0);
            $table->decimal('refunded_amount', 15, 2)->default(0);
            $table->json('daily_orders')->nullable(); // {"2026-01-01": 5, "2026-01-02": 8}
            $table->json('sold_products')->nullable(); // [{"name": "iPhone", "price": 1000, "quantity": 2}]
            $table->timestamps();

            $table->index(['start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
