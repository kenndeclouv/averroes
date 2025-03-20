<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('teacher_has_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade');
            $table->foreignId('teacher_type_id')->constrained('teacher_types')->onDelete('cascade');
            $table->string('description')->nullable();
            $table->timestamps();
        });
        // Drop column type and secondary_type from teachers table
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('secondary_type');
            $table->dropColumn('ktp');
            $table->string('nip')->after('user_id')->nullable()->unique();
            $table->string('last_degree')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_has_types');

        Schema::table('teachers', function (Blueprint $table) {
            $table->enum('type', ['teacher', 'companion', 'headmaster'])->default('teacher');
            $table->enum('secondary_type', ['teacher', 'companion', 'headmaster'])->nullable();

            $table->string('ktp')->nullable()->unique();
            $table->dropColumn('nip');
            $table->dropColumn('last_degree');
        });
    }
};
