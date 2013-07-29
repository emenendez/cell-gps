<?php

use Illuminate\Database\Migrations\Migration;

class CreateLocations extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create locations table
		Schema::create('locations', function($table){
			$table->increments('id');
			$table->integer('phone_id')->unsigned();
			$table->string('location', 64);
			$table->float('altitude')->nullable();
			$table->float('accuracy')->nullable();
			$table->float('altitudeAccuracy')->nullable();
			$table->float('heading')->nullable();
			$table->float('speed')->nullable();
			$table->timestamp('location_time')->nullable();
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
		// Drop locations table
		Schema::drop('locations');
	}

}