<?php
class UnitTestCase_DateTimeV2 extends UnitTestCase {

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
	 * Test that timezone can be changed after instantiation
	 */
	public function testTimezoneChangedAfterInstantiation() {
	
		$datetime = new qCal_DateTime(2010, 10, 10, 10, 10, 10, "Pacific/Tahiti"); // -10 hours
		$this->assertEqual($datetime->getTimezone()->getName(), "Pacific/Tahiti");
		$datetime->setTimezone("America/Los_Angeles");
		$this->assertEqual($datetime->getTimezone()->getName(), "America/Los_Angeles");
	
	}
	/**
	 * Test that date/time can be converted to timestamp
	 */
	public function testTimestampConversion() {
	
		$datetime = qCal_DateTime::factory("03/20/1993 01:00:00pm", "America/Los_Angeles");
		$this->assertEqual($datetime->getUnixTimestamp(), "732632400");
		
		// now get the timestamp WITH the timezone offset
		$this->assertEqual($datetime->getUnixTimestamp(true), "732603600"); // - 8 hours
	
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
	 */
	public function testUTCConversion() {
	
		$datetime = qCal_DateTime::factory("2/22/1988 9:44am", "America/Denver"); // February 22, 1988 at 9:44am Mountain Standard Time
		$this->assertEqual($datetime->getUtc(), "19880222T164400Z"); // UTC is GMT time
		$datetime->setTimezone(new qCal_Timezone("Custom", "3600", "CSTM", false));
		$this->assertEqual($datetime->getUtc(), "19880222T084400Z");
	
	}

}