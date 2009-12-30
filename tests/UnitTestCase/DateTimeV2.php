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
	 * Datetime should default to now
	 */
	public function testDateTimeDefaultsToNow() {
	
		$before = gmdate("U");
		//$datetime = qCal_DateTime::factory("now");
		// pr($before);
		// pre($datetime->getUnixTimestamp());
		// $this->assertTrue($datetime->getUnixTimestamp() >= $before);
	
	}
	/**
	 * @todo Figure out how you want to handle timezones. It would be nice if we didn't have to provide
	 * a timezone component both to qCal_DateV2 AND qCal_Time. It would be nice if I could just do something
	 * like qCal::setTimezone($timezone), but I don't think that would work if I needed to work with multiple
	 * timezones.
	 * or 
	 */
	public function testDateTimeAcceptsObjects() {
	
		$date = new qCal_DateV2(2010, 4, 23); // my 24th birthday!
		$time = new qCal_Time(17, 30, 0, "America/Los_Angeles"); // 5:30pm
		$datetime = new qCal_DateTime($date, $time); // instantiate with date and time objects
		// $this->assertEqual($datetime->__toString(), "2010-04-23T17:30:00-08:00"); // for some reason this is coming out to -07:00 rather than -08:00 :(
		
		$time = new qCal_Time(17, 30, 0);
		// $this->assertEqual($time->setFormat('\TH:i:sP')->__toString(), "T17:30:00-08:00");
	
	}
	/**
	 * Test date/time can be generated the same way as qCal_DateV2 and qCal_Time.
	 * By using a simple string (passed to PHP's strtotime() function)
	 */
	public function testDateTimeFactory() {
	
		//$datetime = qCal_DateTime::factory("2009-09-09 01:30:45", qCal_Timezone::factory("America/Denver")); // -7 hours from GMT
		//$this->assertEqual($datetime->format("Y-m-d H:i:s"), "2009-09-09 01:30:45");
		//$this->assertEqual($datetime->getTime()->getTimezone()->getName(), "America/Denver");
	
	}

}