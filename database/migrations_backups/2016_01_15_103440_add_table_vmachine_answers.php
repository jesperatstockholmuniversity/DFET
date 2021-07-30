<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableVmachineAnswers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vmachine_answers', function($table)
		{
			$table->increments('id');
			$table->integer('vmachine_id');
			$table->integer('question_id');
			$table->string('question_offset', 100);
			$table->string('question_answer', 100);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('vmachine_answers');
	}

}
