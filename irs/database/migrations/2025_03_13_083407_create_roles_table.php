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
        Schema::create('roles', function (Blueprint $table) {
            $table->id('roleID'); //PK
            $table->unsignedBigInteger('AccessID'); //FK
            $table->string('RoleName');
            $table->text('Description');
            $table->timestamps();

            //Define FK
            $table->foreign('AccessID')->references('AccessID')->on('access')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
