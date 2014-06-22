<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('AdminPageSeeder');
	}

}

class AdminPageSeeder extends Seeder {
	public function run()
	{
		$phone = Phone::create(array(
			'user_id' => 1,
			'email' => '2027310827@vtext.com'
			));

		$location = Location::create(array(
			'phone_id' => $phone->id,
			'location' => 'test location',
			'altitude' => 0,
			'accuracy' => 0,
			'altitudeAccuracy' => 0,
			'heading' => 0,
			'speed' => 0
			));
	}
}