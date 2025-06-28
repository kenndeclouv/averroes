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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date("date");
            $table->text("description")->nullable();
            $table->unsignedBigInteger("debit")->nullable();
            $table->unsignedBigInteger("credit")->nullable();

            $table->foreignId('transaction_category_id')->nullable()->constrained('transaction_categories')->onDelete('cascade');
            $table->string("attachment")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
