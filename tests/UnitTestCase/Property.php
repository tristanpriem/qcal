<?php
class UnitTestCase_Property extends UnitTestCase {

	/**
	 * Quick test to make sure property parameters are supported
	 */
	public function testPropertyParametersWork() {
	
		$property = new qCal_Property_Trigger('P1W3DT2H3M45S', array('related' => 'end'));
		$this->assertEqual($property->getParam('related'), 'end');
	
	}

	/**
	 * Test that passing in the VALUE parameter effectively changes the type
	 */
	public function testValueParamChangesPropertyType() {
	
		$property = new qCal_Property_Attach("SOME DATA");
		$this->assertEqual($property->getType(), "URI");
		$property->setParam("value", "binary");
		$this->assertEqual($property->getType(), "BINARY");
		
		$property = new qCal_Property_Attach("SOME DATA", array('value' => 'binary'));
		$this->assertEqual($property->getType(), "BINARY");
	
	}

}