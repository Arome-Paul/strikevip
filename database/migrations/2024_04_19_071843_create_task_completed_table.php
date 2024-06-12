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
        Schema::create('task_completed', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userid');
            $table->unsignedBigInteger('taskid');
            $table->enum('state', ['pending', 'approved'])->default('pending');
            $table->foreign('userid')->references('id')->on('users');
            $table->foreign('taskid')->references('id')->on('tasks');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_completed');
    }
};
