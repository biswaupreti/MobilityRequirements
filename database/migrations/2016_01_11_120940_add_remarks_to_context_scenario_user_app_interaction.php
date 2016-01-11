<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRemarksToContextScenarioUserAppInteraction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('context_scenario_user_app_interaction', function (Blueprint $table) {
            $table->text('remarks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('context_scenario_user_app_interaction', function (Blueprint $table) {
            $table->dropColumn('remarks');
        });
    }
}
