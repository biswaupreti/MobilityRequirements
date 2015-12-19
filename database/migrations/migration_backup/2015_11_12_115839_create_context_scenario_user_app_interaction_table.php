<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContextScenarioUserAppInteractionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('context_scenario_user_app_interaction', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('requirement_id')->unsigned();
            $table->foreign('requirement_id')->references('id')->on('requirements')->onDelete('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('context_id')->unsigned();
            $table->foreign('context_id')->references('id')->on('context_scenario_ideal_way')->onDelete('cascade');
            $table->string('scenario');
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
        Schema::drop('context_scenario_user_app_interaction');
    }
}
