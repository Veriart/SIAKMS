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
        Schema::create('internal_memos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->integer('letter_number');
            $table->string('ref');
            $table->string('pic_name');
            $table->string('reason');
            $table->string('date');
            $table->string('time');
            $table->string('place');
            $table->longText('note');
            $table->longText('ref_file');
            $table->longText('dispen_file');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internal_memos');
    }
};
