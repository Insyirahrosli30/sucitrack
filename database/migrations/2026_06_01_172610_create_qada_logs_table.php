<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qada_logs', function (Blueprint $table) {
            $table->id();

            // link ke user (kalau system kau ada auth)
            $table->unsignedBigInteger('user_id')->nullable();

            // link ke menstrual record (optional tapi penting untuk integration)
            $table->unsignedBigInteger('menstrual_record_id')->nullable();

            // data utama Qada
            $table->date('qada_date')->nullable();
            $table->string('prayer_type')->nullable(); // contoh: Subuh, Zohor etc

            // status tracking
            $table->boolean('is_completed')->default(false);

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qada_logs');
    }
};