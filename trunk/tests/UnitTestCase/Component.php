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
	
		$calendar = new qCal_Component_Vcalendar();
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
		$event = new qCal_Component_Vevent(array(
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