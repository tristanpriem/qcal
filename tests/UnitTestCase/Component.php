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
	 * Test the various types of alarms that are possible
	 */
	public function testAudioAlarm() {
	
		// audio alarm
		$this->expectException(new qCal_Exception_MissingProperty('VALARM component requires TRIGGER property'));
		$alarm = new qCal_Component_Alarm(array(
			'action' => 'audio',
			//'trigger' => '15m'
		));
		
	}
	/**
	 * Test the various types of alarms that are possible
	 */
	public function testDisplayAlarm() {
	
		// display alarm
		$this->expectException(new qCal_Exception_MissingProperty('DISPLAY VALARM component requires DESCRIPTION property'));
		$alarm = new qCal_Component_Alarm(array(
			'action' => 'display',
			'trigger' => 'P1W3DT2H3M45S',
			//'description' => 'Feed your fish'
		));
		
	}
	/**
	 * Test the various types of alarms that are possible
	 */
	public function testEmailAlarm() {
	
		// email alarm
		$this->expectException(new qCal_Exception_MissingProperty('EMAIL VALARM component requires DESCRIPTION property'));
		$alarm = new qCal_Component_Alarm(array(
			'action' => 'email',
			'trigger' => 'P1W3DT2H3M45S',
			'summary' => 'Feed your fish!',
			//'description' => 'Don\'t forget to feed your poor fishy, Pedro V'
		));
		
	}
	/**
	 * Test the various types of alarms that are possible
	 */
	public function testProcedureAlarm() {

		// email alarm
		$this->expectException(new qCal_Exception_MissingProperty('PROCEDURE VALARM component requires ATTACH property'));
		$alarm = new qCal_Component_Alarm(array(
			'action' => 'procedure',
			'trigger' => 'P1W3DT2H3M45S',
			//'attach' => 'http://www.somewebsite.com/387592/alarm/5/',
		));
	
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