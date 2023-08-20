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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_position_id')->nullable();
            $table->foreignId('department_id')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('registration_type')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('signature')->nullable();
            $table->string('password');

            $table->foreign('employee_position_id')
                ->references('id')
                ->on('employee_positions')
                ->nullOnDelete();
            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
