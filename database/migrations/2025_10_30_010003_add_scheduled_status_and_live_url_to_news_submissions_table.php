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
        Schema::table('news_submissions', function (Blueprint $table) {
            // Add scheduled_at and live_url columns
            $table->timestamp('scheduled_at')->nullable()->after('approved_at');
            $table->string('live_url')->nullable()->after('published_at');
        });

        // Modify the status enum to include 'scheduled'
        // Using DB::statement because modifying enum columns requires raw SQL
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE news_submissions MODIFY COLUMN status ENUM('draft', 'pending', 'approved', 'rejected', 'published', 'scheduled') DEFAULT 'draft'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news_submissions', function (Blueprint $table) {
            // Remove the new columns
            $table->dropColumn(['scheduled_at', 'live_url']);
        });

        // Revert status enum to original values
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE news_submissions MODIFY COLUMN status ENUM('draft', 'pending', 'approved', 'rejected', 'published') DEFAULT 'draft'");
    }
};
