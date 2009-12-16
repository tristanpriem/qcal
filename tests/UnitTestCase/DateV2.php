<?php
class UnitTestCase_DateV2 extends UnitTestCase {

	/**
	 * Set up test environment
	 */
	public function setUp() {
	
		
	
	}
	/**
	 * Tear down test environment
	 */
	public function tearDown() {
	
		
	
	}
	public function testDateExceptionAcceptsDateObject() {
	
		$date = new qCal_DateV2;
		$exception = new qCal_Date_Exception("Foo", 0, null, $date);
		$this->assertEqual($exception->getDate(), $date);
		$this->expectException($exception);
		throw $exception;
	
	}
	/**
	 * The object should default to the current date and time
	 */
	public function testDateDefaultsToNow() {
	
		$date = new qCal_DateV2();
		$now = time();
		$this->assertEqual($date->getMonth(), date("m", $now));
		$this->assertEqual($date->getDay(), date("d", $now));
		$this->assertEqual($date->getYear(), date("Y", $now));
		
		// make sure that if only a portion of the date is given, the rest default to now
		$date2 = new qCal_DateV2(2006);
		$this->assertEqual($date2->getMonth(), date("m", $now));
		$this->assertEqual($date2->getDay(), date("d", $now));
		$this->assertEqual($date2->getYear(), "2006");
		
		$date3 = new qCal_DateV2(2006, 5);
		$this->assertEqual($date3->getDay(), date("d", $now));
		$this->assertEqual($date3->getMonth(), "5");
		$this->assertEqual($date3->getYear(), "2006");
	
	}
	
	public function testInvalidDateThrowsException() {
	
		$this->expectException(new qCal_Date_Exception_InvalidDate("Invalid date specified for qCal_DateV2: \"1/35/2009\""));
		$date = new qCal_DateV2(2009, 1, 35);
	
	}
	/**
	 * @todo I wish I could set the server's date to leap-year so that when the qCal_Date
	 * class calls time() it would be leap-year. Then I could test this properly...
	 */
	public function testInvalidLeapYear() {
	
		// you cannot specify a leap-year for a date that is not a leap-year
		$this->expectException(new qCal_Date_Exception_InvalidDate("Invalid date specified for qCal_DateV2: \"2/29/2009\""));
		$date = new qCal_DateV2(2009, 2, 29);
	
	}
	
	public function testSetDateByString() {
	
		$today = getdate();
		$tomorrow = mktime(0, 0, 0, $today['mon'], $today['mday']+1, $today['year']);
		$tomorrow = getdate($tomorrow);
		$date = qCal_DateV2::factory("tomorrow");
		$this->assertEqual($date->getYear(), $tomorrow['year']);
		$this->assertEqual($date->getMonth(), $tomorrow['mon']);
		$this->assertEqual($date->getDay(), $tomorrow['mday']);
	
	}
	/**
	 * The date object has many getters which allow for you to determine things like day of the week,
	 * day of the year, etc. The following tests those getters.
	 */
	public function testGetters() {
	
		$date = new qCal_DateV2(2009, 4, 23);
		$this->assertEqual($date->getWeekDay(true), 4);
		$this->assertEqual($date->getWeekDay(), "Thursday");
	
	}

}