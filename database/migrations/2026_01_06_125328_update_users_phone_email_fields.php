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
        // NULL phone утгатай хэрэглэгчдэд дамми утга өгөх
        DB::table('users')
            ->whereNull('phone')
            ->update(['phone' => DB::raw('CONCAT("99000000", id)')]);

        Schema::table('users', function (Blueprint $table) {
            // Phone-г required болон unique болгох
            $table->string('phone')->nullable(false)->unique()->change();

            // Email-г nullable болгох
            $table->string('email')->nullable()->change();

            // Email unique constraint-г устгах (хэрэв байвал)
            try {
                $table->dropUnique(['email']);
            } catch (\Exception $e) {
                // Unique constraint байхгүй бол алдааг үл хэрэгсэх
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->change();
            $table->string('email')->nullable(false)->unique()->change();
        });
    }
};
