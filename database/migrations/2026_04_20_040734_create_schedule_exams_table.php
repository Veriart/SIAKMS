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
        Schema::create('schedule_exams', function (Blueprint $table) {
            $table->id();
            $table->enum('category', ['ASAS B1', 'ASAT B1', 'ASAS B2', 'ASAT B2', 'ASAJ']);
            $table->foreignId('academic_year_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['Lv. 1', 'Lv. 2', 'Lv. 3', 'A2 Flyers', 'A2 Key', 'B1'])->nullable();
            $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_exams');
    }
};
