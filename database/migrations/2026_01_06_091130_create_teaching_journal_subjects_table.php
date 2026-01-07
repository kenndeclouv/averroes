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
        Schema::create('teaching_journal_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teaching_journal_id')->constrained('teaching_journals')->onDelete('cascade');
            $table->foreignId('teaching_subject_id')->constrained('teaching_subjects')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teaching_journal_subjects');
    }
};
