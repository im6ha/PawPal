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
    Schema::create('lost_pets', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->enum('post_type', ['lost', 'found']);
        $table->enum('pet_type', ['dog', 'cat', 'rabbit', 'bird', 'hamster', 'fish', 'other']);
        $table->string('wilaya');
        $table->string('last_seen_area');
        $table->date('date_lost_found');
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
        Schema::dropIfExists('lost_pets');
    }
};
