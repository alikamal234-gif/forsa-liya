<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('level')->default('beginner')->after('email'); // beginner | intermediate | advanced
            $table->unsignedBigInteger('current_track_id')->nullable()->after('level');
            $table->unsignedBigInteger('current_branch_id')->nullable()->after('current_track_id');
            $table->integer('xp_points')->default(0)->after('current_branch_id');
            $table->integer('projects_completed')->default(0)->after('xp_points');
            $table->integer('projects_passed')->default(0)->after('projects_completed');
        });

        // Add FK constraints after tracks/branches tables exist
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('current_track_id')->references('id')->on('tracks')->nullOnDelete();
            $table->foreign('current_branch_id')->references('id')->on('branches')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['current_track_id']);
            $table->dropForeign(['current_branch_id']);
            $table->dropColumn(['level', 'current_track_id', 'current_branch_id', 'xp_points', 'projects_completed', 'projects_passed']);
        });
    }
};
