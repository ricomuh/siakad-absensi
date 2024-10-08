<?php

use App\Models\SubjectSession;
use App\Models\User;
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
        Schema::create('student_presents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users');
            $table->foreignId('subject_session_id')->constrained('subject_sessions');
            $table->integer('status')->default(1);
            // ip address of the student
            $table->string('ip_address')->nullable();
            // user agent of the student
            $table->string('user_agent')->nullable();
            // location of the student
            $table->string('location')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_presents');
    }
};
