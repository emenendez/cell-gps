<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessages extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create messages table
		Schema::create('messages', function($table){
			$table->increments('id');
			$table->integer('phone_id')->unsigned();
			$table->string('message', 320);
			$table->timestamps();

			$table->foreign('phone_id')
				  ->references('id')->on('phones')
				  ->onUpdate('cascade')
				  ->onDelete('cascade');
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
		Schema::drop('messages');
	}

}
