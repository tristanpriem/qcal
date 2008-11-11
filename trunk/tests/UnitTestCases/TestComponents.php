<?php
Mock::generate('qCal_Component', 'Mock_qCal_Component');
Mock::generate('qCal_Property', 'Mock_qCal_Property');
class TestComponents extends UnitTestCase {

	/**
	 * A nice simple test to start things off...
	 */
	public function testClassTypes() {
	
		$property = new Mock_qCal_Property;
		$component = new Mock_qCal_Component;
		$this->assertTrue($property instanceof qCal_Property);
		$this->assertTrue($component instanceof qCal_Component);
	
	}

}