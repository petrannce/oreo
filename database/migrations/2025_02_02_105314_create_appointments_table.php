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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade'); // Links to Patients Table
            $table->foreignId('booked_by')->nullable()->constrained('users')->onDelete('set null'); // Who booked
            $table->date('date');
            $table->time('time');
            $table->string('service');
            $table->foreignId('doctor_id')->nullable()->constrained('users')->onDelete('set null'); // Doctor assigned
            $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
