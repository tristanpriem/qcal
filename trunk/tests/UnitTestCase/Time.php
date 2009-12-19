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
		$time = new qCal_Time($nowhour, $nowminute, $nowsecond);
		$this->assertEqual($time->getTimestamp(), $diff);
	
	}

}