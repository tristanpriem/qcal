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

}