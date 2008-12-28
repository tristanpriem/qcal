<?php
class UnitTestCase_Component_Alarm extends UnitTestCase {

	public function setUp() {
	
		
	
	}

	public function tearDown() {
	
		
	
	}
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

}