<?php
class UnitTestCase_Component_Calendar extends UnitTestCase {

	public function setUp() {
	
		
	
	}

	public function tearDown() {
	
		
	
	}
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
	 * Test that you can pass in name/value paris, property objects, or a combination, and that
	 * the name portion is case insensitive
	 */
	public function testCalendarInitializeAcceptsMixedArray() {
	
		// name/value pairs
		$properties = array(
			'prodid' => '// Test //',
			'version' => '3.1'
		);
		$calendar = new qCal_Component_Calendar($properties);
		$this->assertEqual($calendar->getProperty('prodid')->getValue(), '// Test //');
		$this->assertEqual($calendar->getProperty('version')->getValue(), '3.1');
		
		// property objects
		$properties = array(
			new qCal_Property_Version('4.0'),
			new qCal_Property_Prodid('// Test //')
		);
		$calendar = new qCal_Component_Calendar($properties);
		$this->assertEqual($calendar->getProperty('prodid')->getValue(), '// Test //');
		$this->assertEqual($calendar->getProperty('version')->getValue(), '4.0');
		
		// combination of property objects and name/value
		$properties = array(
			new qCal_Property_Version('4.0'),
			'prodid' => '// Test //',
		);
		$calendar = new qCal_Component_Calendar($properties);
		$this->assertEqual($calendar->getProperty('prodid')->getValue(), '// Test //');
		$this->assertEqual($calendar->getProperty('version')->getValue(), '4.0');
		
		// @todo what happens if the same property is passed in multiple times, and that isn't allowed?
	
	}

}