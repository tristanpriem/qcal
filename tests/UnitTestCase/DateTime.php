<?php
class UnitTestCase_DateTime extends UnitTestCase {

	protected $formats = array(
		'ISO' => '1986-04-23 12:00:00',
		'timestamp' => '514670400',
		'UTC' => '1986-04-23T12:00Z',
		'YYYY' => '1986',
		'YYYY-MM' => '1986-04',
		'YYYY-MM-DD' => '1986-04-23',
		'YYYY-MM-DDThh:mmTZD' => '1986-04-23T12:00+01:00',
		'YYYY-MM-DDThh:mm:ssTZD' => '1986-04-23T12:00:00+01:00',
	);
	/**
	 * The object should default to the current time
	 */
	public function testDefaultsToNow() {

		// only way I can think to test this
		$before = time();
		$date = new qCal_Date();
		$after = time();
		$this->assertTrue(($before <= $date->time() && $after >= $date->time()));
	
	}
	/**
	 * The object should allow a unix timestamp in the constructor
	 */
	public function testAcceptsUnixTimestamp() {
	
		$date = strtotime("04/23/1988 1:00pm");
		$obj = new qCal_Date($date);
		$this->assertEqual($date, $obj->time());
	
	}
	/**
	 * Make sure the object accepts any format accepted by strtotime
	 */
	public function testAcceptsAnythingThatCanBeParsedWithStrToTime() {
	
		$date = "2003-09-23 12:34:03";
		$obj = new qCal_Date($date);
		$this->assertEqual($obj->time(), strtotime($date));
	
	}
	/**
	 * Format a string with date function
	 */
	public function testFormatString() {
	
		$date = new qCal_Date($this->formats['ISO']);
		$this->assertEqual($date->format('Y-m-d'), '1986-04-23');
	
	}

}