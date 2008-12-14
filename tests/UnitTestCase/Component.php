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
	 * Make sure only valid components may be set on calendar
     */
	public function testCalendarPropertyConformance() {
	
		$this->expectException(new qCal_Exception_InvalidProperty("VCALENDAR component does not allow PERCENT-COMPLETE property"));
		$component = new qCal_Component_Calendar();
		$percentComplete = new qCal_Property_PercentComplete(35);
		$component->addProperty($percentComplete);
	
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
		
		// I commented this out because as of right now I Don't need a component factory
		// do it through factory too
		//$component = qCal_Component::factory('VCALENDAR');
		//$this->assertEqual($component->getProperty('prodid')->getValue(), '-//Luke Visinoni//qCal v0.1//EN');
		//$this->assertEqual($component->getProperty('version')->getValue(), '2.0');
	
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
		$this->expectException(new qCal_Exception_MissingProperty('VALARM component requires ACTION property'));
		$component = new qCal_Component_Alarm();
		// test that trigger is required to initialize an alarm
		$this->expectException(new qCal_Exception_MissingProperty('VALARM component requires TRIGGER property'));
		$component = new qCal_Component_Alarm('AUDIO');
	
	}
	/**
	 * Timezone Component
	 */
	/**
	 * Test that each component gets initialized in accordance with the RFC
	 * conformance rules
	 */
	public function NOSHOWtestTimeZoneInitializeConformance() {
	
		// test that action is required to initialize an alarm
		$this->expectException(new qCal_Exception_MissingProperty('VTIMEZONE component requires TZID property'));
		$component = new qCal_Component_Timezone();
	
	}
	
	/**
	 * Test that non-standard properties can be set on a component.
	 */
	public function NOSHOWtestNonStandardProperties() {
	
		
	
	}

}