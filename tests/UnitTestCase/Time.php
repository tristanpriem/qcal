<?php
class UnitTestCase_Time extends UnitTestCase {

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
	/**
	 * Test that time defaults to now
	 * @note There is a very minor chance of this test failing if it happens to be called at 11:59:58... probably won't happen though.
	 * @note Commented out because it takes too long and it's really not that important of a test
	 */
	/*public function testTimeDefaultsToNow() {
	
		$today = date("Y/m/d");
		$today = strtotime($today);
		$before = time() - $today;
		sleep(1);
		$now = time() - $today;
		sleep(1);
		$time = new qCal_Time();
		sleep(1);
		$after = time() - $today;
		pr("before: $before");
		pr("now: $now");
		pr("after: $after");
		$this->assertTrue(($time->getTimestamp() > $before && $time->getTimestamp() < $after));
	
	}*/
	/**
	 * test that timezone defaults to server's timezone
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
	 * All of PHP's date function's time-related metacharacters should work with this class
	 */
	public function testFormatDateMetacharacters() {
	
		$time = new qCal_Time(4, 20, 0, "GMT");
		$this->assertEqual($time->__toString(), "04:20:00");
		$this->assertEqual($time->format("g:ia"), "4:20am");
	
	}
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
		// $this->assertEqual($time->format(), "");
	
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
	
		$time = new qCal_Time;
		$time->setTime(23, 0, 0, "GMT") // 11 o'clock pm
			->setFormat("g:ia")
			->setTimezone("America/Los_Angeles");
		$this->assertEqual($time->__toString(), "3:00pm");
	
	}
	/**
	 * Test that you can set the timezone after instatiation
	 */
	public function testTimezoneSetter() {
	
		$time = new qCal_Time;
		$time->setTime(0, 0, 0, "GMT");
		$this->assertEqual($time->__toString(), "00:00:00");
		$time->setTimezone(qCal_Timezone::factory("Atlantic/Azores"));
		
		// this tests that the time changes when you change the timezone
		$this->assertEqual($time->__toString(), "23:00:00");
		$this->assertEqual($time->getTimezone()->getAbbreviation(), "AZOT");
		$this->assertEqual($time->getTimezone()->getOffsetSeconds(), "-3600");
		
		// you should also be able to provide the name of the timezone to set it rather than using the factory
		$time2 = new qCal_Time(0, 0, 0, "GMT");
		$this->assertEqual($time2->getTimezone(), qCal_Timezone::factory("GMT"));
		$time2->setTimezone(new qCal_Timezone("CustomTimezone", 3600, "CT", false));
		$this->assertEqual($time2->__toString(), "01:00:00");
		$this->assertEqual($time2->getTimezone()->getName(), "CustomTimezone");
	
	}
	/**
	 * Test that timezone adjusts the time properly.
	 * When you create a new time object, it defaults to GMT time, meaning no
	 * adjustment to the time. When you set a timezone, like America/Los_Angeles, which is
	 * -8 hours from GMT, then that amount of time should be added to the time (subtract 8 hours).
	 * Basically we should get back the timestamp that is equal to the time specified, plus the timezone offset
	 */
	public function testTimezoneAdjustsTime() {
	
		$time = new qCal_Time(8, 0, 0); // 8:00am
		$time->setTimezone(qCal_Timezone::factory("America/Los_Angeles"));
		$this->assertEqual($time->getTimestamp(), "0"); // 8:00am
		$time->setTimezone(qCal_Timezone::factory("GMT"));
		$this->assertEqual($time->getTimestamp(), "28800");
	
	}

}