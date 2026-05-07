<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activity_information_classroom', function (Blueprint $table) {
            // Di MySQL, harus drop foreign key dulu sebelum bisa drop unique index
            // yang dipakai sebagai dasar FK constraint
            $table->dropForeign(['activity_information_id']);
            $table->dropForeign(['classroom_id']);

            // Hapus unique constraint lama
            $table->dropUnique('ai_classroom_unique');

            // Tambah kolom expertise_id (nullable agar backward compat dengan data lama)
            $table->foreignId('expertise_id')
                ->nullable()
                ->after('classroom_id')
                ->constrained()
                ->nullOnDelete();

            // Buat kembali foreign key yang tadi di-drop
            $table->foreign('activity_information_id')
                ->references('id')
                ->on('activity_informations')
                ->cascadeOnDelete();

            $table->foreign('classroom_id')
                ->references('id')
                ->on('classrooms')
                ->cascadeOnDelete();

            // Unique constraint baru: kombinasi activity + classroom + expertise
            $table->unique(
                ['activity_information_id', 'classroom_id', 'expertise_id'],
                'ai_classroom_expertise_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('activity_information_classroom', function (Blueprint $table) {
            $table->dropForeign(['expertise_id']);
            $table->dropUnique('ai_classroom_expertise_unique');
            $table->dropColumn('expertise_id');
            $table->unique(['activity_information_id', 'classroom_id'], 'ai_classroom_unique');
        });
    }
};
