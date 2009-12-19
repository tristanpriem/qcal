<?php
class UnitTestCase_Timezone extends UnitTestCase {

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

	public function testTimezoneDefaultsToServerTimezone() {

		$timezone = new qCal_Time_Timezone();
		$this->assertEqual($timezone->getName(), date_default_timezone_get());

	}
	
	public function testTimezoneOffsetGetters() {
	
		$timezone = new qCal_Time_Timezone("America/Los_Angeles");
		$this->assertEqual($timezone->getOffset(), "-08:00");
		$this->assertEqual($timezone->getOffsetHours(), "-0800");
		$this->assertEqual($timezone->getOffsetSeconds(), "-28800");
		$this->assertEqual($timezone->getAbbreviation(), "PST");
		$this->assertEqual($timezone->isDaylightSavings(), false);
		$this->assertEqual($timezone->getName(), "America/Los_Angeles");
	
	}

	public function testTimezoneSetToGMT() {

		$timezone = new qCal_Time_Timezone("GMT");
		$this->assertEqual($timezone->getName(), "GMT");
		$this->assertEqual($timezone->getOffset(), 0);

	}

}