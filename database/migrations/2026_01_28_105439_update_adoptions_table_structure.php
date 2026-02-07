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
        Schema::table('adoptions', function (Blueprint $blueprint) {
            $blueprint->renameColumn('wilaya', 'location');
        });

        Schema::table('adoptions', function (Blueprint $blueprint) {
            $blueprint->integer('location')->change();

            $blueprint->renameColumn('moderation_status', 'status');
        });

        DB::statement("ALTER TABLE adoptions MODIFY COLUMN status ENUM('pending', 'approved') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('adoptions', function (Blueprint $table) {
            $table->renameColumn('location', 'wilaya');
            $table->renameColumn('status', 'moderation_status');
        });

        Schema::table('adoptions', function (Blueprint $table) {
            $table->string('wilaya')->change();
        });

        DB::statement("ALTER TABLE adoptions MODIFY COLUMN moderation_status ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending'");
    }
};