<?php

use Illuminate\Database\Migrations\Migration;

class CreatePhones extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create phones table
		Schema::create('phones', function($table){
			$table->increments('id');
			$table->integer('user_id');
			$table->string('email', 320);
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
		// Drop phones table
		Schema::drop('phones');
	}

}