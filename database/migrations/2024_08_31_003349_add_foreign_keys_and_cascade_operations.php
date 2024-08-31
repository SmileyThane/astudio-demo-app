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
        Schema::table('user_projects', static function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('user_projects', static function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });

        Schema::table('timesheets', static function (Blueprint $table) {
            $table->foreign('user_projects_id')->references('id')->on('user_projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_projects', static function (Blueprint $table) {
            $table->dropForeign('user_projects_project_id_foreign');
            $table->dropForeign('user_projects_user_id_foreign');
        });

        Schema::table('timesheets', static function (Blueprint $table) {
            $table->dropForeign('timesheets_user_projects_id_foreign');
        });
    }
};
