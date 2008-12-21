<?php
class UnitTestCase_DateTime extends UnitTestCase {

	/**
	 * The object should default to the current time
	 */
	public function testDefaultsToNow() {

		// only way I can think to test this
		$before = time();
		$date = new qCal_DateTime();
		$after = time();
		$this->assertTrue(($before <= $date->toUnixTimestamp() && $after >= $date->toUnixTimeStamp()));
	
	}
	/**
	 * The object should allow a unix timestamp in the constructor
	 */
	public function testAcceptsUnixTimestamp() {
	
		$date = strtotime("04/23/1988 1:00pm");
		$obj = new qCal_DateTime($date);
		$this->assertEqual($date, $obj->toUnixTimestamp());
	
	}

}