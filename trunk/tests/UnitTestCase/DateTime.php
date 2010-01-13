<?php
class UnitTestCase_DateTime extends UnitTestCase {

	/**
	 * Set up test environment
	 */
	public function setUp() {
	
		
	
	}
	/**
	 * Tear down test environment
	 * Set the timezone back to what it was
	 */
	public function tearDown() {
	
		
	
	}
	/**
	 * DateTime is instantiated in the same way qCal_Date and qCal_Time are instantiated
	 * There is also a factory method very similar to those classes (which we'll test next)
	 */
	public function testInstantiateDateTime() {
	
		$year = "2009";
		$month = "4";
		$day = "23";
		$hour = "12";
		$minute = "30";
		$second = "00";
		$timezone = "America/Los_Angeles";
		$rollover = false;
		$datetime = new qCal_DateTime($year, $month, $day, $hour, $minute, $second, $timezone, $rollover); // 4/23/2009 at 12:30:00
		$this->assertEqual($datetime->getYear(), $year);
		$this->assertEqual($datetime->getMonth(), $month);
		$this->assertEqual($datetime->getDay(), $day);
		$this->assertEqual($datetime->getHour(), $hour);
		$this->assertEqual($datetime->getMinute(), $minute);
		$this->assertEqual($datetime->getSecond(), $second);
		$this->assertEqual($datetime->getTimezone()->getName(), $timezone);
	
	}
	/**
	 * Test the factory method
	 */
	public function testFactoryMethod() {
	
		$datetime = qCal_DateTime::factory("03/20/1990 10:00:00pm");
		$this->assertEqual($datetime->getYear(), 1990);
		$this->assertEqual($datetime->getMonth(), 3);
		$this->assertEqual($datetime->getDay(), 20);
		$this->assertEqual($datetime->getHour(), 22);
		$this->assertEqual($datetime->getMinute(), 0);
		$this->assertEqual($datetime->getSecond(), 0);
	
	}
	/**
	 * Factory should accept unix timestamps
	FIGURE OUT HOW TIMEZONES SHOULD WORK HERE...

	public function testFactoryAcceptsUnixTimestamps() {
	
		$dt = qCal_DateTime::factory(1262603182, "GMT");
		$this->assertEqual($dt->__toString(), "2010-01-04T11:06:22");
		
		$dt2 = qCal_DateTime::factory("1262603182", "GMT");
		$this->assertEqual($dt2->__toString(), "2010-01-04T11:06:22");
		
		$dt3 = qCal_DateTime::factory("1262603182", "America/Los_Angeles");
		pre(date("m-d-Y H:i:s", 1262603182));
		//$this->assertEqual($dt3->__toString(), "2010-01-04T03:06:22");
	
	}
	 */
	/**
	 * Test that date/time can be converted to timestamp
	 */
	public function testTimestampConversion() {
	
		$datetime = qCal_DateTime::factory("03/20/1993 01:00:00pm", "America/Los_Angeles");
		// $this->assertEqual(gmdate("g:i:sa", $datetime->getUnixTimestamp(true)), "1:00:00pm");
		// $this->assertEqual(gmdate("g:i:sa", $datetime->getUnixTimestamp(false)), "9:00:00pm");
		
		$defaultTz = date_default_timezone_get();
		
		date_default_timezone_set("America/Los_Angeles");
		// $this->assertEqual(date("g:i", $datetime->getUnixTimestamp(false)), "9:00");
		
		date_default_timezone_set($defaultTz);
	
	}
	/**
	 * Test string output
	 */
	public function testStringOutput() {
	
		$dt = new qCal_DateTime(2000, 10, 1, 5, 0, 0);
		$this->assertEqual($dt->__toString(), "2000-10-01T05:00:00");
	
	}
	/**
	 * Test that format method allows date() function's meta-characters
	 */
	public function testDateTimeFormat() {
	
		$dt = new qCal_DateTime(2000, 10, 1, 5, 0, 0);
		$this->assertEqual($dt->format("m/d/Y H:i:s"), "10/01/2000 05:00:00");
	
	}
	/**
	 * Test conversion to UTC
	 * @todo The entire process for UTC conversion is hacky at best. Fix it up in the next release.
	 */
	public function testUTCConversion() {
	
		$datetime = qCal_DateTime::factory("2/22/1988 5:52am", "America/Denver"); // February 22, 1988 at 5:52am Mountain Standard Time
		// $this->assertEqual($datetime->getUtc(), "19880222T125200Z"); // UTC is GMT time
		
		//$datetime->setTimezone(new qCal_Timezone("Custom", "+3600", "CSTM", false));
		//$this->assertEqual($datetime->getUtc(), "19880222T045200Z"); // changed timezone to GMT + 1 hour
	
	}
	/**
	 * @todo I need to add a test so that something like "19970101T180000Z", when passed to qCal_DateTime::factory()
	 * knows to assign the GMT timezone to it because the "Z" stands for UTC
	 */

}