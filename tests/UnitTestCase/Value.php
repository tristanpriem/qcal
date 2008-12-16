<?php
/**
 * This is a series of tests that ensure that data is property handled in the qCal_Value family of classes
 */
class UnitTestCase_Value extends UnitTestCase {

	/**
	 * Test that binary data is handled right
	 */
	public function testBinaryToString() {
	
		$value = new qCal_Value_Binary("TEST DATA");
		$this->assertEqual($value->__toString(), base64_encode("TEST DATA"));
	
	}
	/**
	 * Test that binary data is handled right
	 */
	public function testActualBinary() {
	
		$binary = file_get_contents('./files/me.jpg');
		$value = new qCal_Value_Binary($binary);
		$this->assertEqual($value->__toString(), base64_encode($binary));
		$this->assertEqual($value->getValue(), $binary);
	
	}
	/**
	 * Test that boolean data is handled right
	 */
	public function testBooleanToString() {
	
		$value = new qCal_Value_Boolean(true);
		$this->assertEqual($value->__toString(), "TRUE");
	
	}
	/**
	 * Test that boolean data is handled right
	 */
	public function testRawBoolean() {
	
		$value = new qCal_Value_Boolean(false);
		$this->assertEqual($value->getValue(), false);
	
	}
	/**
	 * Test that cal-address data is handled right
	 */
	public function testCalAddressToString() {
	
		$value = new qCal_Value_CalAddress('http://www.example.com/webcal');
		$this->assertEqual($value->__toString(), "http://www.example.com/webcal");
	
	}
	/**
	 * Test that cal-address data is handled right
	 */
	public function testRawCalAddress() {
	
		$value = new qCal_Value_CalAddress('http://www.example.com/webcal');
		$this->assertEqual($value->getValue(), 'http://www.example.com/webcal');
	
	}
	/**
	 * Test that uri data is handled right
	 */
	public function testUriToString() {
	
		$value = new qCal_Value_Uri('http://www.example.com/webcal');
		$this->assertEqual($value->__toString(), "http://www.example.com/webcal");
	
	}
	/**
	 * Test that uri data is handled right
	 */
	public function testRawUri() {
	
		$value = new qCal_Value_Uri('http://www.example.com/webcal');
		$this->assertEqual($value->getValue(), 'http://www.example.com/webcal');
	
	}
	/**
	 * Test that date data is handled right
	 */
	public function testDateToString() {
	
		$value = new qCal_Value_Date('2009-04-23');
		$this->assertEqual($value->__toString(), "20090423");
	
	}
	/**
	 * Test that date data is handled right
	 */
	public function testRawDate() {
	
		$value = new qCal_Value_Date('2009-04-23');
		$this->assertEqual($value->getValue(), 1240470000);
	
	}
	/**
	 * Test that date-time data is handled right
	 */
	public function NOSHOWtestDateTimeToString() {
	
		$value = new qCal_Value_DateTime('2009-04-23 6:00');
		$this->assertEqual($value->__toString(), "20090423T");
	
	}
	/**
	 * Test that date-time data is handled right
	 */
	public function NOSHOWtestRawDateTime() {
	
		$value = new qCal_Value_DateTime('2009-04-23 6:00');
		$this->assertEqual($value->getValue(), 1240491600);
	
	}
	/**
	 * Test that duration data is handled right
	 */
	public function testDurationToString() {
	
		$value = new qCal_Value_Duration('P2WT2H45M');
		$this->assertEqual($value->__toString(), 'P2WT2H45M');
	
	}
	/**
	 * Test that duration passed in in an "unnormalized"? format gets corrected
	 */
	public function testDurationToStringNormalizes() {
	
		$value = new qCal_Value_Duration('P18D');
		$this->assertEqual($value->__toString(), 'P2W4D'); // 18 days == 2 weeks and 4 days
	
		$value = new qCal_Value_Duration('P180D18938S'); // 180 days + 18938 seconds 
		$this->assertEqual($value->__toString(), 'P25W5DT5H15M38S'); // converts to 25 weeks, 5 days, 5 hours, 15 minutes, and 38 seconds
	
	}
	/**
	 * Test that duration data is handled right
	 */
	public function testRawDuration() {
	
		$value = new qCal_Value_Duration('P1W3DT2H3M45S');
		$this->assertEqual($value->getValue(), 871425); // this is how many seconds are in the duration
	
	}

}