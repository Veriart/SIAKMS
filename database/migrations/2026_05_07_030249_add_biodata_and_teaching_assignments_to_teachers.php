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
        // Tambah kolom biodata guru
        Schema::table('teachers', function (Blueprint $table) {
            $table->string('nuptk')->nullable()->after('identification_number');
            $table->string('place_of_birth')->nullable()->after('religion');
            $table->date('date_of_birth')->nullable()->after('place_of_birth');
            $table->text('address')->nullable()->after('date_of_birth');
            $table->string('phone')->nullable()->after('address');
            $table->enum('education_level', ['S1', 'S2', 'S3', 'D3', 'D4', 'SMA'])->nullable()->after('phone');
            $table->string('education_major')->nullable()->after('education_level');
            $table->string('position')->nullable()->after('education_major');
            $table->date('join_date')->nullable()->after('position');
        });

        // Buat tabel penugasan mengajar guru
        Schema::create('teacher_subject', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->foreignId('academic_year_id')->constrained()->cascadeOnDelete();
            $table->foreignId('classroom_id')->constrained()->cascadeOnDelete();
            $table->foreignId('expertise_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('hours_per_week')->default(0);
            $table->timestamps();

            $table->unique(
                ['teacher_id', 'subject_id', 'academic_year_id', 'classroom_id', 'expertise_id'],
                'teacher_subject_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_subject');

        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn([
                'nuptk',
                'place_of_birth',
                'date_of_birth',
                'address',
                'phone',
                'education_level',
                'education_major',
                'position',
                'join_date',
            ]);
        });
    }
};
