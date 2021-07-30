<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSectionIdToFiles extends Migration {

  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up() {
    Schema::table('files', function($table) {
      $table->integer('section_id')->nullable();
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down() {
    Schema::table('files', function($table) {
      $table->dropColumn('section_id');
    });
  }

}
