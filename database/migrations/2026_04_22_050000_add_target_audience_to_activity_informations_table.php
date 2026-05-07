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
        Schema::table('activity_informations', function (Blueprint $table) {
            $table->enum('target_audience', ['all', 'teachers', 'students'])->default('all')->after('document_file');
            $table->enum('student_scope', ['all_students', 'specific_classrooms'])->nullable()->after('target_audience');
        });

        Schema::create('activity_information_classroom', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_information_id')->constrained('activity_informations')->cascadeOnDelete();
            $table->foreignId('classroom_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['activity_information_id', 'classroom_id'], 'ai_classroom_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_information_classroom');

        Schema::table('activity_informations', function (Blueprint $table) {
            $table->dropColumn(['target_audience', 'student_scope']);
        });
    }
};
