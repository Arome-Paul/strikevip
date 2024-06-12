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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->enum('state', ['active', 'closed'])->default('active');
            $table->unsignedBigInteger('userid');
            $table->longText('description');
            $table->text('link');
            $table->string('sm');
            $table->string('type');
            $table->unsignedBigInteger('limit');
            $table->unsignedBigInteger('amount');
            $table->foreign('userid')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
