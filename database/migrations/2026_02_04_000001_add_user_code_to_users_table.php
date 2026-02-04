<?php

use App\Models\User;
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
            $table->string('user_code', 6)->nullable()->unique()->after('id');
        });

        User::select('id')->whereNull('user_code')->chunkById(200, function ($users) {
            foreach ($users as $user) {
                $user->user_code = User::generateUserCode();
                $user->saveQuietly();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_user_code_unique');
            $table->dropColumn('user_code');
        });
    }
};
