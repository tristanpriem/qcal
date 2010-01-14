<?php
class UnitTestCase_SprintTwo extends UnitTestCase {

	public function setUp() {
	
		// set up the test environment...
	
	}
	
	public function tearDown() {
	
		// tear down the test environment...
	
	}
	
	/**
	 * The following are tests for all of the examples in the documentation
	 */
	
	public function testDateInstantiationDocumentationExamples() {
	
		$date1 = new qCal_Date(2010, 1, 10); // results in January 10th, 2010
		$this->assertEqual($date1->format("F jS, Y"), "January 10th, 2010");
		
		$date3 = new qCal_Date(2010, 1, 35, true); // results in February 4th, 2010 because the rollover parameter was set to true
		$this->assertEqual($date3->format("F jS, Y"), "February 4th, 2010");
		
		$this->expectException(new qCal_DateTime_Exception_InvalidDate('Invalid date specified for qCal_Date: "1/35/2010"'));
		$date2 = new qCal_Date(2010, 1, 35); // invalid, and will throw a qCal_DateTime_Exception_InvalidDate exception
	
	}
	
	public function testDateConvertToString() {
	
		$date = new qCal_Date(2010, 1, 10);
		$this->assertEqual($date->__toString(), "01/10/2010"); // will output "01/10/2010"
	
	}
	
	public function testDateConvertToStringUsingFormatMethod() {
	
		$date = new qCal_Date(2010, 1, 10);
		$date->setFormat("Y");
		//echo $date; // outputs "2010"

		$date->setFormat('l, F \the jS, Y'); 
		//echo $date; // outputs "Sunday, January the 10th, 2010"
	
	}
	
	/**
	 * Test qCal_DateTime examples
	 */
	public function testGetUtc() {
	
		$datetime = new qCal_DateTime(2009, 10, 31, 10, 30, 0, "America/Los_Angeles");
		$this->assertEqual($datetime->getUtc(), "20091031T183000Z");
		$this->assertEqual($datetime->getUtc(true), "2009-10-31T18:30:00Z");
	
	}

}