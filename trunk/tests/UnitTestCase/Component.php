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
	 */
	public function testFacadeMethods() {
	
		$calendar = new qCal_Component_Calendar();
		$calendar->setProdId('// Test //');
		$this->assertEqual($calendar->getProdid(), '// Test //');
	
	}
	/**
	 * These are examples from other icalendar libraries I've found in various other languages
	 */
	public function testExamplesFromOtherLibraries() {
	
		$cal = new qCal;
		$cal->setProdid('-//My calendar product//mxm.dk//');
		$cal->setVersion('2.0');
		$this->assertEqual($cal->getProdid(), '-//My calendar product//mxm.dk//');
		$this->assertEqual($cal->getVersion(), '2.0');
		
		// events - eventually this will be much more complex, but for now, it works like any other component
		$event = new qCal_Component_Event(array(
			'summary' => 'Python meeting about calendaring',
			'dtstart' => '2009-01-19 6:00',
			'dtend' => '2009-01-19 9:00',
			'dtstamp' => '2009-01-19 9:00',
			'uid' => '20050115T101010/27346262376@mxm.dk'
		));
		$event->setPriority(5);
		$this->assertEqual($event->getSummary(), 'Python meeting about calendaring');
		// returns a timestamp
		$this->assertEqual($event->getDtstart(), '20090119T060000');
		$this->assertEqual($event->getDtend(), '20090119T090000');
		$this->assertEqual($event->getDtstamp(), '20090119T090000');
		$this->assertEqual($event->getUid(), '20050115T101010/27346262376@mxm.dk');
		$this->assertEqual($event->getPriority(), 5);
		
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
		$this->expectException(new qCal_Exception_MissingProperty('VTIMEZONE component requires TZID property'));
		$component = new qCal_Component_Timezone();
	
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
		$event = new qCal_Component_Event();
		$event->attach($cal);
	
	}
	

}