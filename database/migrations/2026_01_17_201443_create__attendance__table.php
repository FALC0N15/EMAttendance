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
        Schema::create('_attendance_', function (Blueprint $table) {
            $table->bigIncrements('studentId');
            $table->text('firstName');
            $table->text('LastName');
            $table->integer('Grade');
            $table->date('last_attended_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_attendance_');
    }
};
