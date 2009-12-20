<?php
class UnitTestCase_Timezone extends UnitTestCase {
	// commented out because it makes the tests fail
	// protected $timezone;
	// /**
	//  * Set up test environment
	//  */
	// public function setUp() {
	// 
	// 	$this->timezone = date_default_timezone_get();
	// 
	// }
	// /**
	//  * Tear down test environment
	//  * Set the timezone back to what it was
	//  */
	// public function tearDown() {
	// 
	// 	date_default_timezone_set($this->timezone);
	// 
	// }
	public function testTimezoneSetsServerTimezoneToGMT() {
	
		// this way, our timezone component works independently of the server timezone.
		// if I can find a way to work with times without having php's functions adjust the output
		// then I will. otherwise, I'll just have to set the timezone to GMT
	
	}
	/**
	 * The timezone defaults to server timezone
	 */
	public function testTimezoneDefaultsToServerTimezone() {

		$timezone = new qCal_Time_Timezone();
		$this->assertEqual($timezone->getName(), date_default_timezone_get());

	}
	/**
	 * Test string output (can be formatted with PHP's date function's timezone-related meta-characters)
	 */
	public function testFormatString() {
	
		$timezone = new qCal_Time_Timezone("America/Los_Angeles");
		$this->assertEqual($timezone->__toString(), "-08:00");
	
	}
	/**
	 * Test that timezone's getters work
	 */
	public function testTimezoneOffsetGetters() {
	
		$timezone = new qCal_Time_Timezone("America/Los_Angeles");
		$this->assertEqual($timezone->getOffset(), "-08:00");
		$this->assertEqual($timezone->getOffsetHours(), "-0800");
		$this->assertEqual($timezone->getOffsetSeconds(), "-28800");
		$this->assertEqual($timezone->getAbbreviation(), "PST");
		$this->assertEqual($timezone->isDaylightSavings(), false);
		$this->assertEqual($timezone->getName(), "America/Los_Angeles");
	
	}
	/**
	 * GMT is an offset of zero. Test that it works as it should.
	 */
	public function testTimezoneSetToGMT() {

		$timezone = new qCal_Time_Timezone("GMT");
		$this->assertEqual($timezone->getName(), "GMT");
		$this->assertEqual($timezone->getOffset(), 0);

	}

}