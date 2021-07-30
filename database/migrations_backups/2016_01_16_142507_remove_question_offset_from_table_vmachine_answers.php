<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveQuestionOffsetFromTableVmachineAnswers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('vmachine_answers', function($table)
		{
		  $table->dropColumn('question_offset');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('vmachine_answers', function($table)
		{
		    $table->string('question_offset')->nullable();
		});
	}

}
