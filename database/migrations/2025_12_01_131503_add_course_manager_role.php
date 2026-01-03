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
        // Normalize the role column to a simple string so we can freely add roles in code.
        // Allowed values are now enforced at the application (validation) level,
        // which avoids MySQL ENUM truncation issues like the one you've been seeing.
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 50)->default('staff')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // If rolled back, revert to a more restrictive enum without student / course_manager.
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'staff'])->default('staff')->change();
        });
    }
};
