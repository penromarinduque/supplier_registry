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
        Schema::create('time_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('user_no');
            $table->enum('division', ['msd', 'tsd', 'pamo']);
            $table->dateTime("am_in")->nullable();
            $table->dateTime("am_out")->nullable();
            $table->dateTime("pm_in")->nullable();
            $table->dateTime("pm_out")->nullable();
            $table->string("am_in_location")->nullable();
            $table->string("am_out_location")->nullable();
            $table->string("pm_in_location")->nullable();
            $table->string("pm_out_location")->nullable();
            $table->dateTime('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_entries');
    }
};
