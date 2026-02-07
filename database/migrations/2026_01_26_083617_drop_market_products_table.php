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
    Schema::dropIfExists('market_products');
}

public function down(): void
{
    // Optional: Define table structure here if you ever want to "rollback"
}
};
