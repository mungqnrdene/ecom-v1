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
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_picture')->nullable()->after('email');
            $table->string('phone')->nullable()->after('email_verified_at');
            $table->string('city')->nullable()->after('phone');
            $table->string('district')->nullable()->after('city');
            $table->text('address')->nullable()->after('district');
            $table->string('apartment_number')->nullable()->after('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['profile_picture', 'phone', 'city', 'district', 'address', 'apartment_number']);
        });
    }
};
