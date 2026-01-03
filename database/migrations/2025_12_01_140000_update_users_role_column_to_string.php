<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Use raw SQL so we don't rely on doctrine/dbal for column changes.
        DB::statement("
            ALTER TABLE users
            MODIFY COLUMN role VARCHAR(50) NOT NULL DEFAULT 'staff'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // If you ever rollback, revert to a basic ENUM with the core roles.
        DB::statement("
            ALTER TABLE users
            MODIFY COLUMN role ENUM('admin','staff','course_manager','student','attendance')
                NOT NULL DEFAULT 'staff'
        ");
    }
};


