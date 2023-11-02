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
            $table->string('login_token')->unique()->nullable();
            $table->string('moodle_uid')->unique()->nullable(); // Add this line
            $table->timestamp('last_login')->nullable(); // Add this line
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('login_token');
            $table->dropColumn('moodle_uid'); // Add this line
            $table->dropColumn('last_login'); // Add this line
        });
    }
};
