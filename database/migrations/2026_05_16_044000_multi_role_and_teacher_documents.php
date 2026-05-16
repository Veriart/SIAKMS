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
        // 1. Hapus kolom role_id dari users (ganti ke Spatie many-to-many)
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role_id');
        });

        // 2. Buat tabel teacher_documents untuk berkas kebutuhan guru
        Schema::create('teacher_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();
            $table->string('document_name');        // Nama dokumen: KTP, KK, Ijazah S1, dll
            $table->string('file_path');             // Path file yang di-upload
            $table->text('notes')->nullable();       // Catatan opsional
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_documents');

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->nullable()->after('password');
        });
    }
};
