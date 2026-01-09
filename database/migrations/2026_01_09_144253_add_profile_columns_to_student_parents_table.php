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
        Schema::table('student_parents', function (Blueprint $table) {
            $table->string('name')->after('user_id')->nullable(); // Made nullable initially to avoid issues with existing records
            $table->string('nik')->nullable()->after('name');
            $table->string('phone')->nullable()->after('nik');
            $table->enum('gender', ['male', 'female'])->default('male')->after('phone');
            $table->string('birth_place')->nullable()->after('gender');
            $table->date('birth_date')->nullable()->after('birth_place');
            $table->text('address')->nullable()->after('birth_date');
            $table->string('profession')->nullable()->after('address');
            $table->bigInteger('income')->nullable()->after('profession');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_parents', function (Blueprint $table) {
            $table->dropColumn([
                'name',
                'nik',
                'phone',
                'gender',
                'birth_place',
                'birth_date',
                'address',
                'profession',
                'income'
            ]);
        });
    }
};
