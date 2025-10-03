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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('email', 100)->unique();
            $table->string('company_name', 100);
            $table->string('authorized_representative', 100);
            $table->string('landline_no', 50);
            $table->string('mobile_no', 15);
            $table->string('philgeps_reg_no', 50);
            $table->date('philgeps_validity');
            $table->string('business_permit_no', 100)->nullable();
            $table->date('business_permit_validity')->nullable();
            $table->string('line_of_business', 200);
            $table->string('valid_id', 100);
            $table->string('philgeps_cert', 100);
            $table->string('business_permit', 100);
            $table->string('bir_cert', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
