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
	public function testConformanceExceptionThrownIfInvalidProperty() {
	
		
	
	}
	/**
	 * Test that each component gets initialized in accordance with the RFC
	 * conformance rules
	 */
	/**
	 * Calendar Component
	 */
	public function testCalendarInitializeConformance() {
	
		// test that prodid is required to initialize a calendar
		/* No longer necessary because prodid defaults to qcal
		$this->expectException(new qCal_Exception_Conformance('PRODID property must be specified for component "VCALENDAR"'));
		$component = new qCal_Component_Calendar();
		*/
	
	}
	/**
	 * Tests that defaults get set correctly when instantiating	
	 **/
	public function testCalendarInitializeDefaults() {
	
		$component = new qCal_Component_Calendar();
		// test calendar defaults. eventually there will be convenience methods
		// that will allow you to do $component->prodid() to get and set
		$this->assertEqual($component->getProperty('prodid')->getValue(), '-//Luke Visinoni//qCal v0.1//EN');
		$this->assertEqual($component->getProperty('version')->getValue(), '2.0');
		
		// do it through factory too
		$component = qCal_Component::factory('VCALENDAR');
		$this->assertEqual($component->getProperty('prodid')->getValue(), '-//Luke Visinoni//qCal v0.1//EN');
		$this->assertEqual($component->getProperty('version')->getValue(), '2.0');
	
	}
	/**
	 * Alarm Component
	 */
	/**
	 * Test that each component gets initialized in accordance with the RFC
	 * conformance rules
	 */
	public function testAlarmInitializeConformance() {
	
		// test that action is required to initialize an alarm
		$this->expectException(new qCal_Exception_Conformance('ACTION property must be specified for component "VALARM"'));
		$component = new qCal_Component_Alarm();
		// test that trigger is required to initialize an alarm
		$this->expectException(new qCal_Exception_Conformance('TRIGGER property must be specified for component "VALARM"'));
		$component = new qCal_Component_Alarm('AUDIO');
	
	}
	/**
	 * Timezone Component
	 */
	/**
	 * Test that each component gets initialized in accordance with the RFC
	 * conformance rules
	 */
	public function testTimeZoneInitializeConformance() {
	
		// test that action is required to initialize an alarm
		$this->expectException(new qCal_Exception_Conformance('TZID property must be specified for component "VTIMEZONE"'));
		$component = new qCal_Component_Timezone();
	
	}
	
	/**
	 * Test that non-standard properties can be set on a component.
	 */
	public function NOSHOWtestNonStandardProperties() {
	
		
	
	}

}