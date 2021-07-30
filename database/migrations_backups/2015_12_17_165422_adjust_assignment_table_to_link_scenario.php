<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdjustAssignmentTableToLinkScenario extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
    Schema::table('assignment', function($table) {
      $table->integer('scenario_id')->nullable();
    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
    Schema::table('assignment', function($table) {
    	if (Schema::hasColumn('assignment', 'scenario_id'))
			{
      	$table->dropColumn('scenario_id');
      }
    });
	}

}
