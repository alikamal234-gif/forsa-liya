<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tracks', function (Blueprint $table) {
            $table->id();
            $table->string('name');           // e.g. Frontend
            $table->string('slug')->unique(); // e.g. frontend
            $table->text('description')->nullable();
            $table->string('icon')->nullable(); // emoji or icon name
            $table->string('color')->nullable(); // hex color for UI
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tracks');
    }
};
