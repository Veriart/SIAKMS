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
        // Tambah kolom target kelas di schedule_exams
        Schema::table('schedule_exams', function (Blueprint $table) {
            $table->enum('target_class_level', ['all', 'X', 'XI', 'XII'])->default('all')->after('end_date');
            $table->enum('class_scope', ['all_classes', 'specific_classrooms'])->nullable()->after('target_class_level');
        });

        // Buat pivot table untuk schedule_exam ↔ classroom (+ expertise_id)
        Schema::create('schedule_exam_classroom', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_exam_id')->constrained()->cascadeOnDelete();
            $table->foreignId('classroom_id')->constrained()->cascadeOnDelete();
            $table->foreignId('expertise_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();

            $table->unique(
                ['schedule_exam_id', 'classroom_id', 'expertise_id'],
                'se_classroom_expertise_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_exam_classroom');

        Schema::table('schedule_exams', function (Blueprint $table) {
            $table->dropColumn(['target_class_level', 'class_scope']);
        });
    }
};
