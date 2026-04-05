<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skills_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->integer('projects_completed')->default(0);
            $table->integer('projects_passed')->default(0);
            $table->boolean('is_validated')->default(false); // validated when >= 1 passed
            $table->timestamps();

            $table->unique(['user_id', 'branch_id']); // one record per user+branch
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skills_progress');
    }
};
