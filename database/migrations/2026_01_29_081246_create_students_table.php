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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('identification_number');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('classroom_id');
            $table->unsignedBigInteger('expertise_id');
            $table->unsignedBigInteger('academic_year_id');
            $table->enum('gender', ['Laki-laki', 'Perempuan']);
            $table->enum('religion', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha'])->nullable();
            $table->enum('status', ['Student', 'Alumni'])->default('Student');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
