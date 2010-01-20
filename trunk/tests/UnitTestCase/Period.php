<?php
class UnitTestCase_Period extends UnitTestCase {

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
	
	public function testPeriodConstructor() {
	
		$period = new qCal_DateTime_Period("2009-04-23 6:00pm", "2009-04-30 9:00pm");
		$this->assertEqual($period->getStart(), new qCal_DateTime(2009, 4, 23, 18, 0, 0));
		$this->assertEqual($period->getEnd(), new qCal_DateTime(2009, 4, 30, 21, 0, 0));
	
	}

}