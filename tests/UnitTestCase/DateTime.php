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

}