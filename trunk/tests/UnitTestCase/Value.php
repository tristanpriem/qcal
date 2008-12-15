<?php
/**
 * This is a series of tests that ensure that data is property handled in the qCal_Value family of classes
 */
class UnitTestCase_Value extends UnitTestCase {

	/**
	 * Test that binary data is handled right
	 */
	public function testBinary() {
	
		$value = new qCal_Value_Binary("TEST DATA");
		$this->assertEqual($value->__toString(), base64_encode("TEST DATA"));
	
	}

}