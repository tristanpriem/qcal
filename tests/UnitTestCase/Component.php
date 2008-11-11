<?php
Mock::generate('qCal_Component', 'Mock_qCal_Component');
Mock::generate('qCal_Property', 'Mock_qCal_Property');
class UnitTestCase_Component extends UnitTestCase {

	/**
	 * A nice simple test to start things off...
	 */
	public function testClassTypes() {
	
		$property = new Mock_qCal_Property;
		$component = new Mock_qCal_Component;
		$this->assertTrue($property instanceof qCal_Property);
		$this->assertTrue($component instanceof qCal_Component);
	
	}
	/**
	 * Test that you cannot set an invalid property on a component. Many
	 * properties are specific to certain components.
	 */
	public function testClassTypes() {
	
		$component = new Mock_qCal_Component;
		/*
        $this->expectException(new qCal_Exception_Conformance('PRODID property cannot be specefied for component: "' . $component->getName() . '"'));
		$component->prodId('PRODUCT ID');
        */
	
	}

}