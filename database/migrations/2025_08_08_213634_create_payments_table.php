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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->decimal('amount');
            $table->string('payment_id')->nullable();
            // $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('invoice')->nullable();
            $table->string('status')->nullable();
            $table->string('statusMessage')->nullable();
            $table->string('status_code')->nullable();
            $table->string('msisdn')->nullable();
            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
