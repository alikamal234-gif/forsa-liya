<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->json('requirements')->nullable();     // array of requirement strings
            $table->json('constraints')->nullable();      // array of constraint strings
            $table->json('expected_features')->nullable(); // array of feature strings
            $table->string('difficulty')->default('beginner'); // beginner|intermediate|advanced
            $table->timestamp('deadline')->nullable();    // simulated deadline
            $table->enum('status', ['active', 'submitted', 'failed', 'passed'])->default('active');
            $table->json('ai_generated_data')->nullable(); // raw AI response for reference
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
