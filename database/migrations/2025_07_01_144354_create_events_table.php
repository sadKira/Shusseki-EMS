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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('date');
            $table->string('location');
            $table->time('time_in');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('school_year');
            $table->string('image');
            $table->enum('status', ['not_finished', 'finished', 'postponed'])->default('not_finished');
            $table->enum('tsuushin_request', ['approved', 'not_approved'])->default('not_approved');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
