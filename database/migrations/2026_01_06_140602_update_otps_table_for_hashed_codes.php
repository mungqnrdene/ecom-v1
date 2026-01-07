<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('otps', function (Blueprint $table) {
            $table->timestamp('used_at')->nullable()->after('expires_at');
        });

        DB::statement('ALTER TABLE otps MODIFY code VARCHAR(255)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('otps', function (Blueprint $table) {
            $table->dropColumn('used_at');
        });

        DB::statement('ALTER TABLE otps MODIFY code VARCHAR(6)');
    }
};
