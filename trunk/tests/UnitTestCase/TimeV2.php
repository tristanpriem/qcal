<?php
class UnitTestCase_TimeV2 extends UnitTestCase {

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

}