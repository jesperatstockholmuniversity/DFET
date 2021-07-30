<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOS extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vmachine_os', function($table)
		{
			$table->increments('id');
			$table->string('name', 100);
		});

		DB::table('vmachine_os')->insert([
			'name' => "Kali"
		]);

		DB::table('vmachine_os')->insert([
			'name' => "Windows7"
		]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('vmachine_os');
	}

}
