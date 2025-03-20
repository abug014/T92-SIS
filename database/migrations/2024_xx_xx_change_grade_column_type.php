<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // First, remove any existing check constraint
        try {
            DB::statement("ALTER TABLE student_subjects DROP CONSTRAINT IF EXISTS check_valid_grade");
        } catch (\Exception $e) {
            // Constraint might not exist, continue
        }

        // Modify the grade column to allow string values for "INC"
        Schema::table('student_subjects', function (Blueprint $table) {
            $table->string('grade', 10)->nullable()->change();
        });

        // Add a new check constraint that allows both numeric grades and "INC"
        DB::statement("
            ALTER TABLE student_subjects
            ADD CONSTRAINT check_valid_grade
            CHECK (
                grade IS NULL OR
                grade = 'INC' OR
                CAST(grade AS DECIMAL(3,2)) IN (
                    1.00, 1.25, 1.50, 1.75,
                    2.00, 2.25, 2.50, 2.75,
                    3.00, 3.25, 3.50, 3.75,
                    4.00, 5.00
                )
            )
        ");
    }

    public function down()
    {
        try {
            DB::statement("ALTER TABLE student_subjects DROP CONSTRAINT IF EXISTS check_valid_grade");
        } catch (\Exception $e) {
            // Constraint might not exist, continue
        }

        Schema::table('student_subjects', function (Blueprint $table) {
            $table->decimal('grade', 5, 2)->nullable()->change();
        });
    }
};