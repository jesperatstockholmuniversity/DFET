<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCourseIdToFilesSection extends Migration {

  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up() {
    Schema::table('files_section', function($table) {
      $table->integer('course_id')->nullable();
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down() {
    Schema::table('files_section', function($table) {
      $table->dropColumn('course_id');
    });
  }

}
