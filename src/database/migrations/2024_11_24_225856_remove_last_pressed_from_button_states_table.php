<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveLastPressedFromButtonStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('button_states', function (Blueprint $table) {
            $table->dropColumn('last_pressed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('button_states', function (Blueprint $table) {
            $table->string('last_pressed')->nullable()->after('break_end');
        });
    }
}
