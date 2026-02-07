<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sitters', function (Blueprint $table) {
        });

        Schema::table('sitters', function (Blueprint $table) {
            $table->integer('location')->change();
        });

        DB::statement("ALTER TABLE sitters MODIFY COLUMN status ENUM('pending', 'approved') NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        Schema::table('sitters', function (Blueprint $table) {
            $table->renameColumn('location', 'wilaya');
            $table->renameColumn('status', 'moderation_status');
        });

        Schema::table('sitters', function (Blueprint $table) {
            $table->string('wilaya')->change();
        });

        DB::statement("ALTER TABLE sitters MODIFY COLUMN moderation_status ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending'");
    }
};