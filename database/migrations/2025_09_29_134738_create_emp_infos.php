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
        Schema::create('emp_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->enum('division', ['msd', 'tsd', 'pamo']);
            $table->integer('userID');
            $table->integer('badgeNumber');
            $table->string('SSN')->nullable();
            $table->string('name');
            $table->enum('gender', ['M', 'F'])->nullable();
            $table->string('position', 100);
            $table->string('contact')->nullable();
            $table->date('birthday')->nullable();
            $table->string('address', 100)->nullable();
            $table->string('tin', 16)->nullable();
            $table->enum('salary_type', ['monthly', 'daily'])->default('daily');
            $table->double('monthly_rate', 8, 2)->nullable();
            $table->double('daily_rate', 8, 2)->nullable();
            $table->integer('w_premium')->default(0);
            $table->string('pap', 100)->nullable();
            $table->enum('status', ['Permanent', 'COS', 'SPES', 'OJT', 'GIP']);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emp_infos');
    }
};
