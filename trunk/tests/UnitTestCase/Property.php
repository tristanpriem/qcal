<?php
class UnitTestCase_Property extends UnitTestCase {

	/**
	 * Quick test to make sure property parameters are supported
	 */
	public function testPropertyParametersWork() {
	
		$property = new qCal_Property_Trigger('5m', array('related' => 'end'));
		$this->assertEqual($property->getParam('related'), 'end');
	
	}

}