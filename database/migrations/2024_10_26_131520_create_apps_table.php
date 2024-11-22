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
        Schema::create('apps', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('institution');
            $table->string('logo');
            $table->string('description');
            $table->string('computer_name');
            $table->string('printer_name');
            $table->string('video')->nullable();
            $table->string('banner')->nullable();
            $table->string('developer');
            $table->boolean('use_printer');
            $table->boolean('audio_online');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apps');
    }
};
