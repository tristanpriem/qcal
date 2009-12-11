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
	/**
	 * The object should default to the current date and time
	 */
	public function testDateDefaultsToNow() {
	
		$date = new qCal_DateV2();
		$now = time();
		$this->assertEqual($date->format("mdY"), date("mdY", $now));
	
	}

}