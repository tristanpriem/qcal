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
	 * Test facade methods
	 * I decided to get rid of the facade methods at least for now since getAttendee 
	 * can potentially return multiple values and that makes the interface inconsistent

	public function testFacadeMethods() {
	
		$calendar = new qCal_Component_Vcalendar();
		$calendar->setProdId('// Test //');
		$this->assertEqual($calendar->getProdid(), '// Test //');
	
	}
	 */
	/**
	 * These are examples from other icalendar libraries I've found in various other languages
	 */
	public function testExamplesFromOtherLibraries() {
	
		$cal = new qCal;
		$cal->addProperty('prodid', '-//My calendar product//mxm.dk//');
		$cal->addProperty('version', '2.0');
		// $prodid = $cal->getProperty('prodid');
		// $this->assertEqual($prodid[0]->getValue(), '-//My calendar product//mxm.dk//');
		// $version = $cal->getProperty('version');
		// $this->assertEqual($version[0]->getValue(), '2.0');
		
	}
	
	/**
	 * Test that non-standard properties can be set on a component.
	 */
	public function NOSHOWtestNonStandardProperties() {
	
		
	
	}
	/**
	 * ATTACHING COMPONENTS
	 */
	/**
	 * only certain components can be attached to eachother
	 */
	public function testInvalidAttaching() {
	
		$this->expectException(new qCal_Exception_InvalidComponent('VCALENDAR cannot be attached to VEVENT'));
		// calendars cannot be attached to anything (except perhaps other calendars)
		$cal = new qCal;
		$event = new qCal_Component_Vevent();
		$event->attach($cal);
	
	}
	/**
	 * The factory method is used in the parser. It may eventually be used in the facade methods as well
	 * The factory should accept the name of the component as the first param and the properties as the second
	 * It should also be completely case-insensitive
	 * It will also accept VCALENDAR or just CALENDAR
	 */
	public function NOSHOWtestFactoryMethod() {
	
		$component = qCal_Component::factory('VALARM', array());
		//$component = qCal_Component::factory('ALARM', array('action' => 'audio', 'TriggER' => 'P1w3Dt2H3M45S'));
	
	}
	

}