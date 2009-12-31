<?php
class UnitTestCase_Time extends UnitTestCase {

	/**
	 * Test that timezone defaults to server timezone
	 */
	public function testTimezoneDefault() {
	
		$time = new qCal_Time(0, 0, 0);
		$this->assertEqual($time->getTimezone()->getName(), date_default_timezone_get());
	
	}
	/**
	 * Setting the timezone adjusts the offset used when calculating the timestamp
	 */
	public function testSetTimezone() {
	
		$time = new qCal_Time(0, 0, 0, "GMT");
		$this->assertEqual($time->getHour(), 0);
		$this->assertEqual($time->getTimezone()->getOffsetSeconds(), 0);
		$this->assertEqual($time->getTimestamp(), 0);
		$this->assertEqual($time->getTimestamp(true), 0);
		
		// set timezone with string
		$time->setTimezone("America/Los_Angeles");
		$this->assertEqual($time->getHour(), 0);
		$this->assertEqual($time->getTimezone()->getOffsetSeconds(), -28800);
		$this->assertEqual($time->getTimestamp(), 0);
		$this->assertEqual($time->getTimestamp(true), -28800);
		$this->assertEqual($time->getTimezone(), qCal_Timezone::factory("America/Los_Angeles"));
		
		// set timezone with object
		$timezone = new qCal_Timezone("Custom", 7200, "CSTM", false); // GMT + 2 hours
		$time->setTimezone($timezone);
		$this->assertEqual($time->getHour(), 0);
		$this->assertEqual($time->getTimezone()->getOffsetSeconds(), 7200);
		$this->assertEqual($time->getTimestamp(), 0);
		$this->assertEqual($time->getTimestamp(true), 7200);
		$this->assertEqual($time->getTimezone(), $timezone);
	
	}
	/**
	 * The time component is supposed to work in the most logical way. You create a time like this:
	 * $time = new qCal_Time(4, 30, 0, "America/Los_Angeles");
	 * $time->getHour(); // 4
	 * $time->getTimestamp(); // timestamp should be equal to the time specified but at GMT
	 * $time->setTimezone("GMT");
	 * $time->getHour(); // still 4
	 * $time->getTimestamp(); // timestamp 
	 */
	public function testHourMinuteSecondDontChangeWhenTimezoneChangesOnlyTimestampDoes() {
	
		// create time in America/Los_Angeles: 10:30:00 in PST (America/Los_Angeles)
		$time = new qCal_Time(10, 30, 0, "America/Los_Angeles");
		
		// requesting hour, minute, or second should return the instantiated hour, minute or second
		$this->assertEqual($time->getHour(), 10);
		$this->assertEqual($time->getMinute(), 30);
		$this->assertEqual($time->getSecond(), 0);
		
		// requesting the timestamp should return the time specified, but in GMT
		$this->assertEqual($time->getTimestamp(), 37800);
		// passing "true" to getTimestamp() should return the time specified, but with the offset applied
		$this->assertEqual($time->getTimestamp(true), 9000); // -8 hours
		
		// now change the timezone and try again...
		$time->setTimezone("America/New_York"); // GMT - 5 hours
		$this->assertEqual($time->getHour(), 10);
		$this->assertEqual($time->getMinute(), 30);
		$this->assertEqual($time->getSecond(), 0);
		$this->assertEqual($time->getTimestamp(), 37800);
		$this->assertEqual($time->getTimestamp(true), 19800); // -5 hours
	
	}
	/**
	 * Because PHP stores the time as how many seconds since unix epoch, we cannot simply create a
	 * time component without a date attached to it. We MUST have a date attached to it. To make things
	 * simple, we store the time as how many seconds since start of unix epoch. That way it is like
	 * it is how many seconds since the start of the day, which is close to storing time without a date
	 */
	public function testTimestampIsHowManySecondsSinceSecondZeroOfToday() {
	
		$today = strtotime(date("Y/m/d"));
		$now = strtotime(date("Y/m/d G:i:s"));
		$nowhour = date("G", $now);
		$nowminute = date("i", $now);
		$nowsecond = date("s", $now);
		$diff = $now - $today;
		$time = new qCal_Time($nowhour, $nowminute, $nowsecond, qCal_Timezone::factory("GMT"));
		$this->assertEqual($time->getTimestamp(), $diff);
	
	}
	/**
	 * All of PHP's date function's time-related meta-characters should work with this class
	 * Any of the other meta-characters defined for date() do not work.
	 */
	public function testFormatDateMetacharacters() {
	
		$time = new qCal_Time(4, 20, 0, "GMT");
		$this->assertEqual($time->__toString(), "04:20:00");
		$this->assertEqual($time->format("g:ia"), "4:20am");
	
	}
	/**
	 * Test that setting the format causes __toString to use that format thereafter
	 */
	public function testSetFormat() {
	
		$time = new qCal_Time(21, 15, 0, "GMT");
		$time->setFormat("g:i:sa");
		$this->assertEqual($time->__toString(), "9:15:00pm");
	
	}
	/**
	 * Time rolls over similar to how qCal_DateV2 rolls over, but it is off by default
	 */
	public function testTimeRolloverException() {
	
		$this->expectException(new qCal_DateTime_Exception_InvalidTime("Invalid time specified for qCal_Time: \"01:01:100\""));
		$time = new qCal_Time(1, 1, 100); // should rollover to 1:02:40, but doesn't because rollover is off by default
	
	}
	/**
	 * Time rolls over similar to how qCal_DateV2 rolls over
	 */
	public function testTimeRollover() {
	
		$time = new qCal_Time(1, 1, 100, qCal_Timezone::factory("GMT"), true); // should rollover to 1:02:40
		$this->assertEqual($time->getTimestamp(), 3760);
	
	}
	/**
	 * Test Time Getters (hours, minutes, seconds, etc.)
	 */
	public function testTimeGetters() {
	
		$time = new qCal_Time(8, 10, 5, "GMT");
		$this->assertEqual($time->getHour(), 8);
		$this->assertEqual($time->getMinute(), 10);
		$this->assertEqual($time->getSecond(), 5);
	
	}
	/**
	 * You can use any of the date() function's time-related metacharacters
	 */
	public function testTimeFormat() {
	
		$time = new qCal_Time(1, 0, 0, "GMT");
		$time->setFormat("G:i:sa");
		$this->assertEqual($time->__toString(), "1:00:00am");
	
	}
	/**
	 * Test that metacharacters can be escaped with a backslash
	 */
	public function testEscapeMetacharacters() {
	
		$time = new qCal_Time(0, 0, 0, "GMT");
		$time->setFormat("\G:\i:\s\a G:i:sa");
		$this->assertEqual($time->__toString(), "G:i:sa 0:00:00am");
	
	}
	/**
	 * Test that all of qCal_Time's setters are fluid, meaning they return an instance of themself
	 */
	public function testFluidMethods() {
	
		$time = new qCal_Time(3, 0, 0);
		$time->setFormat("g:ia")
			->setTimezone("America/Los_Angeles");
		$this->assertEqual($time->__toString(), "3:00am");
	
	}
	/**
	 * Time can be generated from string by using the factory method
	 */
	public function testFactoryMethod() {
	
		// test with default timezone
		$time = qCal_Time::factory("1:30pm"); // should default to America/Los_Angeles
		$this->assertEqual($time->getHour(), 13);
		$this->assertEqual($time->getMinute(), 30);
		$this->assertEqual($time->getSecond(), 0);
		$this->assertEqual($time->getTimezone()->getName(), date_default_timezone_get());
		
		// test with specific timezone
		$time = qCal_Time::factory("1:30pm", "MST"); // GMT - 7 hours
		$this->assertEqual($time->getHour(), 13); // timezone doesn't change the time
		$this->assertEqual($time->getMinute(), 30);
		$this->assertEqual($time->getSecond(), 0);
		$this->assertEqual($time->getTimezone()->getName(), "MST");
	
	}
	/**
	 * Swatch Internet Time (http://en.wikipedia.org/wiki/Swatch_Internet_Time)
	 * This is a method of time-keeping that eliminates leap-years, leap-seconds, timezones, daylight savings,
	 * non-decimal units, and all of the other inconsistencies and annoyances which you normally have to deal
	 * with when working with times.
	 */
	public function testSwatchInternetTime() {
	
		// @todo Because this method of time-keeping has not been widely adopted,
		// I don't feel it is a real priority at the moment, but it's something I do intend to implement eventually
	
	}
	/**
	 * @todo Look into the leap-second and what this class needs to do to support it
	 */
	public function testLeapSecond() {
	
		// coming soon!
	
	}

}