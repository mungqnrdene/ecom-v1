<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE `orders` MODIFY `payment_method` ENUM('card','qpay','bank_transfer','cash_on_delivery') NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE `orders` MODIFY `payment_method` ENUM('card','cash_on_delivery') NULL");
    }
};
