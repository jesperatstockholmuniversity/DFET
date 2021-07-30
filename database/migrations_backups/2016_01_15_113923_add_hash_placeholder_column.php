<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHashPlaceholderColumn extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('scenario_questions', function($table)
		{
		    $table->string('hash_placeholder')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('scenario_questions', function($table)
		{
		    $table->dropColumn('hash_placeholder');
		});
	}

}
