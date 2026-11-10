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
        Schema::create('motorcycles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained('brands')->restrictOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->string('model', 150)->index();
            $table->smallInteger('year')->index();
            $table->decimal('price', 15, 2)->index();
            $table->unsignedBigInteger('mileage');
            $table->integer('engine_capacity');
            $table->string('transmission', 30);
            $table->string('color', 50);
            $table->text('description');
            $table->string('status', 20)->default('draft')->index();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            // Additional composite or explicit indexes
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motorcycles');
    }
};

