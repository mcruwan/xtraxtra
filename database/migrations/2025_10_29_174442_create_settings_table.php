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
        if (!Schema::hasTable('settings')) {
            Schema::create('settings', function (Blueprint $table) {
                $table->id();
                $table->string('key')->unique();
                $table->text('value')->nullable();
                $table->string('type')->default('text'); // text, image, boolean, number
                $table->text('description')->nullable();
                $table->timestamps();
            });
        } else {
            // Table exists, check if we need to add missing columns
            // The second migration will handle adding type and description columns
            if (!Schema::hasColumn('settings', 'type')) {
                Schema::table('settings', function (Blueprint $table) {
                    $table->string('type')->default('text')->after('value');
                });
            }
            if (!Schema::hasColumn('settings', 'description')) {
                Schema::table('settings', function (Blueprint $table) {
                    $table->text('description')->nullable()->after('type');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
