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

	public function testTimezoneSetToGMT() {

		$timezone = new qCal_Time_Timezone("GMT");
		$this->assertEqual($timezone->getName(), "GMT");
		$this->assertEqual($timezone->getOffset(), 0);

	}

}