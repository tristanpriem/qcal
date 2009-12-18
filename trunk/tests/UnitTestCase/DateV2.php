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
	 * The same instantiation as was done in the test above will not throw an exception, but instead
	 * will just roll over the extra four days into the next month if you specify the fourth argument as true
	 */
	public function testDateRollover() {
	
		$date = new qCal_DateV2(2009, 1, 35, true);
		$this->assertEqual($date->getMonth(), 2);
		$this->assertEqual($date->getDay(), 4);
		$this->assertEqual($date->getYear(), 2009);
		
		// make sure year can roll over too
		$date2 = new qCal_DateV2(2009, 12, 41, true);
		$this->assertEqual($date2->getMonth(), 1);
		$this->assertEqual($date2->getDay(), 10);
		$this->assertEqual($date2->getYear(), 2010);
	
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
	 * Calling __toString will output the date in the format specified by calling setFormat()
	 * You can use any of the date-related meta characters from php's date() function. Time-related
	 * formatting will not work.
	 */
	public function testToString() {
	
		$date = new qCal_DateV2(2009, 12, 7);
		// format defaults to m/d/Y
		$this->assertEqual($date->__toString(), '12/07/2009');
		// european format
		$date->setFormat('d/m/Y');
		$this->assertEqual($date->__toString(), '07/12/2009');
		// no leading zeros
		$date->setFormat('n/j/Y');
		$this->assertEqual($date->__toString(), '12/7/2009');
		// two-digit year
		$date->setFormat('n/j/y');
		$this->assertEqual($date->__toString(), '12/7/09');
		
		// time-related date meta-characters do not work
		$date->setFormat('m/d/Y h:i:sa');
		$this->assertEqual($date->__toString(), '12/07/2009 h:i:sa');
		
		// you can escape meta-characters with a backslash
		$date->setFormat('\m\d\ymdy');
		$this->assertEqual($date->__toString(), 'mdy120709');
	
	}
	/**
	 * The date object has many getters which allow for you to determine things like day of the week,
	 * day of the year, etc. The following tests those getters.
	 */
	public function testGetters() {
	
		$date = new qCal_DateV2(2009, 4, 23);
		
		// month
		$this->assertEqual($date->getMonth(), 4);
		$this->assertEqual($date->getMonthName(), "April");
		$this->assertEqual($date->getNumDaysInMonth(), 30);
		
		// day
		$this->assertEqual($date->getDay(), 23);
		$this->assertEqual($date->getYearDay(), 112);
		$this->assertEqual($date->getFirstDayOfMonth()->__toString(), "04/01/2009");
		$this->assertEqual($date->getFirstDayOfMonth()->format("l"), "Wednesday");
		$this->assertEqual($date->getLastDayOfMonth()->__toString(), "04/30/2009");
		$this->assertEqual($date->getLastDayOfMonth()->format("l"), "Thursday");
		
		// year
		$this->assertEqual($date->getYear(), 2009);
		
		// week
		$this->assertEqual($date->getWeekDay(), 4);
		$this->assertEqual($date->getWeekDayName(), "Thursday");
		$this->assertEqual($date->getWeekOfYear(), 17);
		
		// unix timestamp
		$this->assertEqual($date->getUnixTimestamp(), mktime(0,0,0,4,23,2009));
	
	}
	/**
	 * Any of the setters in the object will return the object itself
	 */
	public function testFluidMethods() {
	
		$date = new qCal_DateV2(2009, 12, 17);
		$this->assertEqual($date->setFormat("m/d/Y")->__toString(), "12/17/2009");
	
	}
	
	/**
	 * The following are methods that test the date component's ability to do "date magic".
	 * It tests things such as the date component's ability to determine if this is the 2nd
	 * monday of the month, or the 2nd to last monday of the month. Or how many days from the
	 * end of the year it is. Or whether it is the 2nd Tuesday of the year. Or whether
	 */
	
	/**
	 * This method tests that the date component is capable of determining of the date is the
	 * Xth Xday of the month. For instance, it can determine if this date is the third Sunday
	 * of the month or the second to last Tuesday of the month.
	 * 
	 * Internally, maybe the date component should do some of this kind of stuff and cache it
	 * so that it doesn't have to actually do anything when a method like this is called.
	 */
	/*public function test_Is_Xth_Xday_Of_The_Month() {
	
		$date = new qCal_DateV2(2009, 12, 15);
		$this->assertTrue($date->isXthWeekdayOfMonth("Tuesday", 3));
		$this->assertTrue($date->isXthWeekdayOfMonth("Tuesday", -3));
	
	}*/

}