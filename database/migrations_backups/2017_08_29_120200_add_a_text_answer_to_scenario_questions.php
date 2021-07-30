<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddATextAnswerToScenarioQuestions extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('scenario_questions', function($table)
    {
      $table->string('text_answer')->nullable();
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
      $table->dropColumn('text_answer');
    });
  }

}
