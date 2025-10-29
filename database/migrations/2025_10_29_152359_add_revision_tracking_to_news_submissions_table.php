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
            $table->boolean('is_revision')->default(false)->after('published_at');
            $table->string('previous_status')->nullable()->after('is_revision');
            $table->timestamp('last_edited_at')->nullable()->after('previous_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news_submissions', function (Blueprint $table) {
            $table->dropColumn(['is_revision', 'previous_status', 'last_edited_at']);
        });
    }
};
