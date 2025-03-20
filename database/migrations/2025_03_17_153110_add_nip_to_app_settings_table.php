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
        Schema::table('app_settings', function (Blueprint $table) {
            $table->string('nip_prefix')->nullable();
            $table->integer('nip_start_number')->default(1);
            $table->integer('nip_padding')->default(4);
            $table->string('nip_suffix')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('app_settings', function (Blueprint $table) {
            $table->dropColumn([
                'nip_prefix',
                'nip_start_number', 
                'nip_padding',
                'nip_suffix'
            ]);
        });
    }
};
