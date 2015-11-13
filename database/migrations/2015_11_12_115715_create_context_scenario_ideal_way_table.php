<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContextScenarioIdealWayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('context_scenario_ideal_way', function (Blueprint $table) {
            $table->increments('id');
            $table->string('context_name');
            $table->string('typical_scenario');
            $table->boolean('accompanying');
            $table->boolean('intermittent');
            $table->boolean('interrupting');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('context_scenario_ideal_way');
    }
}
