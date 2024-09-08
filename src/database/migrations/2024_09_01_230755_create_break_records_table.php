<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBreakRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('break_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attendance_record_id');
            $table->dateTime('break_start');
            $table->dateTime('break_end');
            $table->dateTime('break_total');
            $table->timestamps();

            $table->foreign('attendance_record_id')->references('id')->on('attendance_records')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('break_records');
    }
}
