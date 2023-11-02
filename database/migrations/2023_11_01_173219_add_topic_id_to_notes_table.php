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
        Schema::table('notes', function (Blueprint $table) {
            // Add the topic_id column as an unsigned big integer
            $table->unsignedBigInteger('topic_id')->after('id'); // 'after' method is optional, it specifies the position of the new column

            // Set up the foreign key relationship
            $table->foreign('topic_id')->references('id')->on('topics')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['topic_id']);

            // Drop the topic_id column
            $table->dropColumn('topic_id');
        });
    }
};
