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
        Schema::table('messages', function (Blueprint $table) {
            $table->string('attachment_path')->nullable()->after('message');
            $table->string('attachment_original_name')->nullable()->after('attachment_path');
            $table->string('attachment_mime')->nullable()->after('attachment_original_name');
            $table->string('attachment_size')->nullable()->after('attachment_mime');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn([
                'attachment_path',
                'attachment_original_name',
                'attachment_mime',
                'attachment_size'
            ]);
        });
    }
};
