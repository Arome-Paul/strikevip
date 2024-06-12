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
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userid');
            $table->integer('referees')->default(0);
            $table->string('referer_code');
            $table->unsignedBigInteger('referred_by')->nullable();
            $table->string('profile_photo')->default('profile/default.jpg');
            $table->integer('structure')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_name')->nullable();
            $table->integer('account_number')->nullable();
            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
