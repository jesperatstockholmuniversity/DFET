<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemakeScenarioTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
    Schema::table('scenario', function($table) {
    	if (Schema::hasColumn('scenario', 'attacker_ip'))
			{
      	$table->dropColumn('attacker_ip');
      }
    	if (Schema::hasColumn('scenario', 'attacker_date'))
			{
      	$table->dropColumn('attacker_date');
      }
    	if (Schema::hasColumn('scenario', 'attacker_entrypoint_file'))
			{
	      $table->dropColumn('attacker_entrypoint_file');
      }
    	if (Schema::hasColumn('scenario', 'attacker_entrypoint_line'))
			{
	      $table->dropColumn('attacker_entrypoint_line');
      }
    	if (Schema::hasColumn('scenario', 'attacker_stolen_data'))
			{
	      $table->dropColumn('attacker_stolen_data');
      }

    	if (Schema::hasColumn('scenario', 'attacker_option1_ip'))
			{
	      $table->dropColumn('attacker_option1_ip');
      }
    	if (Schema::hasColumn('scenario', 'attacker_option1_date'))
			{
	      $table->dropColumn('attacker_option1_date');
      }
    	if (Schema::hasColumn('scenario', 'attacker_option1_entrypoint_file'))
			{
	      $table->dropColumn('attacker_option1_entrypoint_file');
      }
    	if (Schema::hasColumn('scenario', 'attacker_option1_entrypoint_line'))
			{
	      $table->dropColumn('attacker_option1_entrypoint_line');
      }
    	if (Schema::hasColumn('scenario', 'attacker_option1_stolen_data'))
			{
	      $table->dropColumn('attacker_option1_stolen_data');
      }

    	if (Schema::hasColumn('scenario', 'attacker_option2_ip'))
			{
	      $table->dropColumn('attacker_option2_ip');
      }
    	if (Schema::hasColumn('scenario', 'attacker_option2_date'))
			{
	      $table->dropColumn('attacker_option2_date');
      }
    	if (Schema::hasColumn('scenario', 'attacker_option2_entrypoint_file'))
			{
	      $table->dropColumn('attacker_option2_entrypoint_file');
      }
    	if (Schema::hasColumn('scenario', 'attacker_option2_entrypoint_line'))
			{
	      $table->dropColumn('attacker_option2_entrypoint_line');
      }
    	if (Schema::hasColumn('scenario', 'attacker_option2_stolen_data'))
			{
	      $table->dropColumn('attacker_option2_stolen_data');
      }

      $table->string('name',128)->nullable();
    });

		Schema::create('scenario_questions', function($table)
		{
		  $table->increments('id');
      $table->integer('scenario_id');
      $table->string('question',256)->nullable();
      $table->string('hash_offset',128)->nullable();
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
    Schema::table('scenario', function($table) {
      $table->string('attacker_ip', 255)->nullable();
      $table->timestamp('attacker_date')->nullable();
      $table->string('attacker_entrypoint_file', 200)->nullable();
      $table->integer('attacker_entrypoint_line')->nullable();
      $table->text('attacker_stolen_data')->nullable();

      $table->string('attacker_option1_ip', 255)->nullable();
      $table->timestamp('attacker_option1_date')->nullable();
      $table->string('attacker_option1_entrypoint_file', 200)->nullable();
      $table->integer('attacker_option1_entrypoint_line')->nullable();
      $table->text('attacker_option1_stolen_data')->nullable();

      $table->string('attacker_option2_ip', 255)->nullable();
      $table->timestamp('attacker_option2_date')->nullable();
      $table->string('attacker_option2_entrypoint_file', 200)->nullable();
      $table->integer('attacker_option2_entrypoint_line')->nullable();
      $table->text('attacker_option2_stolen_data')->nullable();

    	if (Schema::hasColumn('scenario', 'name'))
			{
	      $table->dropColumn('name');
      }
    	if (Schema::hasColumn('scenario', 'hash_offset'))
			{
	      $table->dropColumn('hash_offset');
      }
    });

		Schema::dropIfExists('scenario_questions');
	}

}
