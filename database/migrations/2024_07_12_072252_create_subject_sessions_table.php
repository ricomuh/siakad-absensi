<?php

use App\Models\Schedule;
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
        Schema::create('subject_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_subject_id')
                ->constrained('class_subjects');
            $table->foreignId('schedule_id')
                ->nullable()
                ->constrained('schedules');
            $table->string('uuid')->unique();
            $table->text('qr_code')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject_sessions');
    }
};
