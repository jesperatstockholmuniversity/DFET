<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCreatedAtAndUpdatedAtToTableVmachineAnswers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
    Schema::table('vmachine_answers', function($table) {
      $table->timestamp('created_at')->nullable();
      $table->timestamp('updated_at')->nullable();
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
		    $table->dropColumn('created_at');
		    $table->dropColumn('updated_at');
		});
	}

}
