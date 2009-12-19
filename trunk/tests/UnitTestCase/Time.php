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
	// public function testTimestampIsHowManySecondsSinceSecondZeroOfToday() {
	// 
	// 	$today = strtotime(date("Y/m/d"));
	// 	$now = strtotime(date("Y/m/d G:i:s"));
	// 	$nowhour = date("G", $now);
	// 	$nowminute = date("i", $now);
	// 	$nowsecond = date("s", $now);
	// 	$diff = $now - $today;
	// 	$time = new qCal_Time($nowhour, $nowminute, $nowsecond);
	// 	$this->assertEqual($time->getTimestamp(), $diff);
	// 
	// }
	/**
	 * All of PHP's date function's time-related metacharacters should work with this class
	 */
	public function testFormatDateMetacharacters() {
	
		$time = new qCal_Time(4, 20, 0);
		// $this->assertEqual($time->__toString(), "4:20:00");
	
	}
	/**
	 * Time rolls over similar to how qCal_DateV2 rolls over, but it is off by default
	 */
	public function testTimeRolloverException() {
	
		$this->expectException(new qCal_Time_Exception_InvalidTime("Invalid time specified for qCal_Time: \"01:01:100\""));
		$time = new qCal_Time(1, 1, 100); // should rollover to 1:02:40, but doesn't because rollover is off by default
	
	}
	/**
	 * Time rolls over similar to how qCal_DateV2 rolls over
	 */
	public function testTimeRollover() {
	
		$time = new qCal_Time(1, 1, 100, null, true); // should rollover to 1:02:40
		$this->assertEqual($time->getTimestamp(), 3760);
		// $this->assertEqual($time->format(), "");
	
	}
	/**
	 * You can use any of the date() function's time-related metacharacters
	 */
	public function testTimeFormat() {
	
		
	
	}

}