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
		$component = new qCal_Component_Valarm();
		// test that trigger is required to initialize an alarm
		$this->expectException(new qCal_Exception_MissingProperty('VALARM component requires TRIGGER property'));
		$component = new qCal_Component_Valarm('AUDIO');
	
	}
	/**
	 * Test the various types of alarms that are possible
	 */
	public function testAudioAlarm() {
	
		// audio alarm
		$this->expectException(new qCal_Exception_MissingProperty('VALARM component requires TRIGGER property'));
		$alarm = new qCal_Component_Valarm(array(
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
		$alarm = new qCal_Component_Valarm(array(
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
		$alarm = new qCal_Component_Valarm(array(
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
		$alarm = new qCal_Component_Valarm(array(
			'action' => 'procedure',
			'trigger' => 'P1W3DT2H3M45S',
			//'attach' => 'http://www.somewebsite.com/387592/alarm/5/',
		));
	
	}
	/**
	 *             ; 'action' and 'trigger' are both REQUIRED,
	 *             ; but MUST NOT occur more than once
	 */
	public function testActionAndTriggerRequiredButCannotOccurMoreThanOnce() {
	
		$alarm = new qCal_Component_Valarm(array(
			'action' => 'audio',
			'trigger' => 'p15m'
		));
		// @todo Should this throw an exception since display requires description?
		$alarm->addProperty('action', 'display');
		$action = $alarm->getProperty('action');
		$this->assertEqual(count($action), 1);
		$alarm->addProperty('trigger', 'p30d');
		$trigger = $alarm->getProperty('trigger');
		$this->assertEqual(count($trigger), 1);
	
	}
	/**
	 *             ; 'duration' and 'repeat' are both optional,
	 *             ; and MUST NOT occur more than once each,
	 *             ; but if one occurs, so MUST the other
	 */
	public function testIfDurationOccursSoMustRepeat() {
	
		$this->expectException(new qCal_Exception_MissingProperty('VALARM component with a DURATION property requires a REPEAT property'));
		$alarm = new qCal_Component_Valarm(array(
			'action' => 'audio',
			'duration' => 'p30m',
			'trigger' => 'p20d'
		));
		$this->expectException(new qCal_Exception_MissingProperty('VALARM component with a REPEAT property requires a DURATION property'));
		$alarm2 = new qCal_Component_Valarm(array(
			'action' => 'audio',
			'repeat' => 'p30m',
			'trigger' => 'p20d'
		));
	
	}
	/**
	 *             ; the following are optional,
	 *             ; and MAY occur more than once
	 * 
	 *             attach / x-prop
	 * 
	 *   The RFC specifies these as examples:
	 *   ATTACH:CID:jsmith.part3.960817T083000.xyzMail@host1.com
	 * 
	 *   ATTACH;FMTTYPE=application/postscript:ftp://xyzCorp.com/pub/
	 *    reports/r-960812.ps
	 * @todo I'm not sure how the first one is suppose to work... :(
	 */
	public function testAttachAndNonStandardCanOccurMultipleTimes() {
	
		$alarm = new qCal_Component_Valarm(array(
			'action' => 'audio',
			'trigger' => 'P1M'
		));
		$attach1 = new qCal_Property_Attach('ftp://xyzCorp.com/pub/reports/r-960812.ps', array(
			'fmttype' => 'application/postscript'
		));
		$alarm->addProperty($attach1);
		$attach2 = new qCal_Property_Attach('ftp://xyzCorp.com/pub/reports/r-960813.ps', array(
			'fmttype' => 'application/postscript'
		));
		$alarm->addProperty($attach2);
		$attaches = $alarm->getProperty('attach');
		$this->assertEqual(count($attaches), 2);
		
		// now try non-standard properties
		$alarm2 = new qCal_Component_Valarm(array(
			'action' => 'audio',
			'trigger' => 'P1M'
		));
		$ns1 = new qCal_Property_NonStandard('foobar', array(
			'x-foo' => 'baz'
		), 'x-lv-email');
		$alarm2->addProperty($ns1);
		$ns2 = new qCal_Property_NonStandard('luke.visinoni@gmail.com', array(
			'altrep' => 'lvisinoni@foobar.com'
		), 'x-lv-email');
		$alarm2->addProperty($ns2);
		$ns = $alarm2->getProperty('x-lv-email');
		$this->assertEqual(count($ns), 2);
	
	}
	/**
	 *             ; 'description' is optional,
	 *             ; and MUST NOT occur more than once
	 */
	public function testDescriptionIsOptionalAndCannotOccurMoreThanOnce() {
	
		$alarm = new qCal_Component_Valarm(array(
			'action' => 'procedure',
			'trigger' => 'P15M',
			'attach' => 'http://www.example.com/foo'
		));
		$alarm->addProperty(new qCal_Property_Description('This is a description'));
		$alarm->addProperty(new qCal_Property_Description('This is another description'));
		$this->assertEqual(count($alarm->getProperty('description')), 1);
	
	}
	/**
	 * When the action is "AUDIO", the alarm can also include one and only
	 * one "ATTACH" property, which MUST point to a sound resource, which is
	 * rendered when the alarm is triggered.
	 * @todo I'm still not really sure when validation should occur. I called it manually here.
	 */
	public function testAudioAlarmCanIncludeOneAndOnlyOneAttachProperty() {
	
		$this->expectException(new qCal_Exception_InvalidProperty('VALARM audio component can contain one and only one ATTACH property'));
		$alarm = new qCal_Component_Valarm(array(
			'action' => 'audio',
			'trigger' => 'P45Y',
			'attach' => 'http://www.example.com/foobar.mp3'
		));
		$alarm->addProperty('attach', 'http://www.example.com/boofar.mp3');
		$alarm->validate();
	
	}
	/**
	 * When the action is "PROCEDURE", the alarm MUST include one and only
	 * one "ATTACH" property, which MUST point to a procedure resource,
	 * which is invoked when the alarm is triggered.
	 */
	public function testProcedureAlarmCanIncludeOneAndOnlyOneAttachProperty() {
	
		$this->expectException(new qCal_Exception_InvalidProperty('VALARM procedure component can contain one and only one ATTACH property'));
		$alarm = new qCal_Component_Valarm(array(
			'action' => 'procedure',
			'trigger' => 'P45Y',
			'attach' => 'http://www.example.com/foobar.mp3'
		));
		$alarm->addProperty('attach', 'http://www.example.com/boofar.mp3');
		$alarm->validate();
	
	}

}