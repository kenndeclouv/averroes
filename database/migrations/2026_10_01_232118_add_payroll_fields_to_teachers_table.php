<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->string('no_rekening')->nullable()->after('address')->comment('Nomor rekening bank guru/staf');
            $table->string('bank')->nullable()->after('no_rekening')->comment('Nama bank, misal: BSI, BCA, Mandiri');
            $table->unsignedBigInteger('gaji_pokok')->nullable()->after('bank')->comment('Gaji pokok bulanan (Rp)');
            $table->unsignedBigInteger('tunjangan_fungsional')->nullable()->after('gaji_pokok')->comment('Tunjangan fungsional bulanan (Rp)');
            $table->unsignedBigInteger('tunjangan_transport')->nullable()->after('tunjangan_fungsional')->comment('Tunjangan transport bulanan (Rp)');
            $table->unsignedInteger('rate_jp')->nullable()->after('tunjangan_transport')->comment('Rate per JP mengajar (Rp/JP)');
            $table->unsignedInteger('potongan_alpha')->nullable()->after('rate_jp')->comment('Potongan per hari alpha (Rp/hari)');
        });
    }

    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn([
                'no_rekening',
                'bank',
                'gaji_pokok',
                'tunjangan_fungsional',
                'tunjangan_transport',
                'rate_jp',
                'potongan_alpha',
            ]);
        });
    }
};
