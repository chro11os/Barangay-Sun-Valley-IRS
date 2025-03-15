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
        Schema::create('incident_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incident_id')->constrained('incidents')->onDelete('cascade'); // FK
            $table->unsignedBigInteger('ResidentID'); // FK
            $table->unsignedBigInteger('methodID'); // FK
            $table->string('incident_reporter_name');
            $table->string('incident_suspect_name');
            $table->string('Email')->nullable();
            $table->string('PhoneNumber')->nullable();
            $table->timestamps();

            $table->foreign('ResidentID')->references('id')->on('residents')->onDelete('cascade');
            $table->foreign('methodID')->references('methodID')->on('method')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incident_reports');
    }
};
