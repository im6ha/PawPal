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
    Schema::create('adoptions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->enum('pet_type', ['dog', 'cat', 'rabbit', 'bird', 'hamster', 'fish', 'other']);
        $table->enum('gender', ['male', 'female', 'unknown']);
        $table->string('wilaya');
        $table->text('description')->nullable();
        $table->string('image_path');
        $table->enum('moderation_status', ['pending', 'approved', 'rejected'])->default('pending');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adoptions');
    }
};
