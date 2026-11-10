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
        Schema::create('motorcycle_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('motorcycle_id')->constrained('motorcycles')->cascadeOnDelete();
            $table->string('image_path', 255);
            $table->boolean('is_primary')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['motorcycle_id', 'is_primary']);
            $table->index(['motorcycle_id', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motorcycle_images');
    }
};

