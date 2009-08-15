<?php
class UnitTestCase_Component_Timezone extends UnitTestCase {

	/**
	 * Test that each component gets initialized in accordance with the RFC
	 * conformance rules
	 */
	public function testTimeZoneInitializeConformance() {
	
		// test that action is required to initialize an alarm
		$this->expectException(new qCal_Exception_MissingProperty('VTIMEZONE component requires TZID property'));
		$component = new qCal_Component_Vtimezone();
	
	}
	/**
	 *                ; 'tzid' is required, but MUST NOT occur more
	 *                ; than once
	 */
	public function testTzidIsRequiredButMustNotOccurMoreThanOnce() {
	
		$standard = new qCal_Component_Standard(array(
			'tzoffsetto' => '-0500',
			'tzoffsetfrom' => '-0400',
			'dtstart' => '19971026T020000'
		));
		$tz = new qCal_Component_Vtimezone(array(
			'tzid' => 'California-Los_Angeles',
		), array($standard));
		$tz->addProperty(new qCal_Property_Tzid('New_York-New_York'));
		$tzid = $tz->getProperty('tzid');
		$this->assertEqual(count($tzid), 1);
		$this->assertEqual($tzid[0]->getValue(), 'New_York-New_York');
	
	}
	/**
	 *                ; 'last-mod' and 'tzurl' are optional,
	 *              but MUST NOT occur more than once
	 */
	public function testLastModAndTzurlMustNotOccurMoreThanOnce() {
	
		$standard = new qCal_Component_Standard(array(
			'tzoffsetto' => '-0500',
			'tzoffsetfrom' => '-0400',
			'dtstart' => '19971026T020000'
		));
		$tz = new qCal_Component_Vtimezone(array(
			'tzid' => 'California-Los_Angeles',
			'last-modified' => new qCal_Date(time()),
			'tzurl' => 'http://www.example.com/tz1',
		), array($standard));
		$newtime = time();
		$tz->addProperty('last-modified', $newtime);
		$tz->addProperty(new qCal_Property_Tzurl('http://www.example.com/tz2'));
		$tzlm = $tz->getProperty('last-modified');
		$tzurl = $tz->getProperty('tzurl');
		$this->assertEqual(count($tzlm), 1);
		$this->assertEqual(count($tzurl), 1);
		$this->assertEqual($tzlm[0]->getValue(), date('Ymd\THis', $newtime));
		$this->assertEqual($tzurl[0]->getValue(), 'http://www.example.com/tz2');
	
	}
	/**
	 * The "VTIMEZONE" calendar component MUST include the "TZID" property
	 * and at least one definition of a standard or daylight component. The
	 * standard or daylight component MUST include the "DTSTART",
	 * "TZOFFSETFROM" and "TZOFFSETTO" properties.
	 */
	public function testOneOfStandardOrDaylightMustOccurAndMayOccurMoreThanOnce() {
	
		$this->expectException(new qCal_Exception_MissingComponent('Either a STANDARD or DAYLIGHT component is required within a VTIMEZONE component'));
		$tz = new qCal_Component_Vtimezone(array(
			'tzid' => 'US-Eastern',
		), array(
			// $standard
		));
		$standard = new qCal_Component_Standard(array(
			'tzoffsetto' => '-0500',
			'tzoffsetfrom' => '-0400',
			'dtstart' => '19971026T020000'
		));
		$standard2 = new qCal_Component_Standard(array(
			'tzoffsetto' => '-0600',
			'tzoffsetfrom' => '-0500',
			'dtstart' => '19981026T020000'
		));
		$tz->attach($standard);
		$tz->attach($standard2);
		$tz->validate(); // shouldn't throw an exception now that standard was attached
		$chidren = $tz->getChildren();
		$this->assertEqual(count($children), 2);
	
	}
	/**
	 * An individual "VTIMEZONE" calendar component MUST be specified for
	 * each unique "TZID" parameter value specified in the iCalendar object.
	 * @todo Finish this when you are more sure how timezones will work
	 */
	public function zzztestEachTzidParameterMustHaveCorrespondingVTimezone() {
	
		$cal = new qCal;
		$todo1 = new qCal_Component_Vtodo(array(
			'summary' => 'Make the monkey wash the cat',
			'description' => 'Make the monkey wash the cat with a cloth. Make sure to also video-tape it.',
			new qCal_Property_Dtstart('20090815T050000', array('tzid' => 'US-Eastern')),
		));
		$todo2 = new qCal_Component_Vtodo(array(
			'summary' => 'Make the cat wash the monkey',
			'description' => 'Make the cat wash the monkey with a sponge. Make sure to audio-tape it.',
			new qCal_Property_Dtstart('20090816T050000', array('tzid' => 'US-Pacific')),
		));
		$this->expectException(new qCal_Exception_MissingComponent('TZID "US-Eastern" not defined'));
		$this->expectException(new qCal_Exception_MissingComponent('TZID "US-Pacific" not defined'));
		$cal->attach($todo1);
		$cal->attach($todo2);
	
	}
	
}
?>