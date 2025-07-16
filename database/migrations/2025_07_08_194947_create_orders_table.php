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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('service_id');
            $table->enum('status', ['pending', 'received', 'completed','cancelled'])->default('pending');
            $table->decimal('cost');
            $table->boolean('paid')->default(false);
            $table->string('payment_id')->nullable();
            $table->boolean('notified')->default(false);
            $table->string('name')->nullable();
            // $table->string('bc_number')->nullable();
            $table->string('dob')->nullable();
            $table->string('nid_number',)->nullable();
            // $table->string('nid_picture')->nullable();
            // $table->string('sign_picture')->nullable();
            // $table->string('user_picture')->nullable();
            $table->string('type')->nullable();
            $table->string('type_number')->nullable();
            $table->string('type_name')->nullable();
            // $table->string('uploaded_file')->nullable();
            $table->string('downloaded_file')->nullable();
            $table->longText('description')->nullable();
            $table->longText('downloaded_info')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
