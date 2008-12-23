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
	 * Test that period data is handled right

	public function testPeriodToString() {
	
		$value = new qCal_Value_Period('19970101T180000Z/PT5H30M');
		//$value = new qCal_Value_Period('19970101T180000Z/19970102T070000Z');
		$this->assertEqual($value->__toString(), "19970101T180000Z/19970102T070000Z");
	
	}
	 */
	/**
	 * Test that period data is handled right

	public function testRawPeriod() {
	
		//$value = new qCal_Value_Period('');
		//$this->assertEqual($value->getValue(), '');
	
	}
	 */
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
		$this->assertEqual($value->getValue(), new qCal_Date('2009-04-23'));
	
	}
	/**
	 * Test that date-time data is handled right
	 */
	public function testDateTimeToString() {
	
		$value = new qCal_Value_DateTime('2009-04-23 6:00');
		$this->assertEqual($value->__toString(), "20090423T060000");
	
	}
	/**
	 * Test that date-time data is handled right
	 */
	public function testRawDateTime() {
	
		$value = new qCal_Value_DateTime('2009-04-23 6:00');
		$this->assertEqual($value->getValue(), new qCal_Date('2009-04-23 6:00'));
	
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
		// @todo: this doesn't handle negative values yet
		/*
		$value = new qCal_Value_Duration('-P180D18938S'); // 180 days + 18938 seconds 
		$this->assertEqual($value->__toString(), '-P25W5DT5H15M38S'); // converts to 25 weeks, 5 days, 5 hours, 15 minutes, and 38 seconds
		*/
	}
	/**
	 * Test that duration data is handled right
	 */
	public function testRawDuration() {
	
		$value = new qCal_Value_Duration('P1W3DT2H3M45S');
		$this->assertEqual($value->getValue(), 871425); // this is how many seconds are in the duration
	
	}
	/**
	 * Test that float data is handled right
	 */
	public function testFloatToString() {
	
		$value = new qCal_Value_Float(5.667);
		$this->assertIdentical($value->__toString(), '5.667');
	
	}
	/**
	 * Test that float data is handled right
	 */
	public function testRawFloat() {
	
		$value = new qCal_Value_Float(5.667);
		$this->assertIdentical($value->getValue(), 5.667); // this is how many seconds are in the duration
	
	}
	/**
	 * Test that integer data is handled right
	 */
	public function testIntegerToString() {
	
		$value = new qCal_Value_Integer(5667);
		$this->assertIdentical($value->__toString(), '5667');
	
	}
	/**
	 * Test that integer data is handled right
	 */
	public function testRawInteger() {
	
		$value = new qCal_Value_Integer(5667);
		$this->assertIdentical($value->getValue(), 5667); // this is how many seconds are in the duration
	
	}
	/**
	 * Test that integer data is handled right
	 */
	public function testTextToString() {
	
		$value = new qCal_Value_Text('text');
		$this->assertIdentical($value->__toString(), 'text');
	
	}
	/**
	 * Test that integer data is handled right
	 */
	public function testRawText() {
	
		$value = new qCal_Value_Text('text');
		$this->assertIdentical($value->getValue(), 'text'); // this is how many seconds are in the duration
	
	}
	/**
	 * Date/Time testing
	public function testPearDate() {
	
		$date = new Date();
		pre($date);
	
	}
	 */

}