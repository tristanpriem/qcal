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

}