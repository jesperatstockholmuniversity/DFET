<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDefaultColumnsToFilesSection extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
    Schema::table('files_section', function($table) {
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
    Schema::table('files_section', function($table) {
      $table->dropColumn('created_at');
      $table->dropColumn('updated_at');
    });
	}

}
