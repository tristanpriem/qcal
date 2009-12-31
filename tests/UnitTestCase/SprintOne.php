<?php
class UnitTestCase_SprintOne extends UnitTestCase {

	public function setUp() {
	
		// set up the test environment...
	
	}
	
	public function tearDown() {
	
		// tear down the test environment...
	
	}
	
	/**
	 * The date component also needs to be capable of efficiently computing things such as...
	 */
	
	/**
	 * Which weekday of the month or year it is (ie: 2nd Tuesday in January, last Sunday of
	 * the month, fourth from last Monday of the year, etc.)
	 */
	public function testDateComponentCanDetermineWhichWeekDayOfMonthOrYearItIs() {
	
		$date = new qCal_DateV2(2009, 2, 22);
		$this->assertEqual($date->getWeekDayName(), "Sunday");
		$this->assertEqual($date->getXthWeekdayOfMonth(-1), $date); // last sunday of the month
		$this->assertEqual($date->getXthWeekdayOfMonth(4), $date); // fourth sunday of the month
		$this->assertNotEqual($date->getXthWeekdayOfMonth(2), $date); // NOT the second Sunday of the month
		$this->assertEqual($date->getXthWeekdayOfYear(8), $date); // eighth sunday of the year
		$this->assertEqual($date->getXthWeekdayOfYear(-45), $date);
	
	}
	
	/**
	 * How many days from the beginning or end of the month or year it is
	 * (ie: February 15th is the 46th day of the year and 13 days from the end of the month)
	 */
	public function testHowManyDaysFromTheBeginningOrEndOfTheMonthOrYearItIs() {
	
		$date = new qCal_DateV2(2010, 1, 15, "GMT"); // mom's birthday!
		$this->assertEqual($date->getYearDay(), 14); // year day starts at zero
		$this->assertEqual($date->getYearDay(true), 15); // pass true to the method and it will start from one
	
	}

}