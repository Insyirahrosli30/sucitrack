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
        Schema::create('menstrual_records', function (Blueprint $table) {

    $table->id();

    $table->foreignId('user_id')
          ->constrained()
          ->onDelete('cascade');

    $table->dateTime('start_datetime');

    $table->dateTime('end_datetime')
          ->nullable();

    $table->integer('duration_days')
          ->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menstrual_records');
    }
};
