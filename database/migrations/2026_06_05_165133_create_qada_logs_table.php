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
    Schema::create('qada_logs', function (Blueprint $table) {
        $table->id();
     
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
        // Detailed log information fields
        $table->string('prayer_name'); // 'fajr', 'zuhr', 'asr', 'maghrib', 'isya'
        $table->date('missed_date');   // The specific date the prayer was missed
        $table->boolean('is_completed')->default(false); // Checkbox tracker state
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qada_logs');
    }
};
