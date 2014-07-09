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
			'user_id' => User::guestId(),
			'email' => '1234567890@vtext.com',
			'created_at' => '2014-06-01 00:00:00',
			));

		$location = Location::create(array(
			'phone_id' => $phone->id,
			'location' => 'test location',
			'altitude' => 0,
			'accuracy' => 0,
			'altitudeAccuracy' => 0,
			'heading' => 0,
			'speed' => 0,
			'created_at' => '2014-07-01 00:00:00',
			));
	}
}