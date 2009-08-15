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
	
		$tz = new qCal_Component_Vtimezone(array(
			'tzid' => 'California-Los_Angeles',
		));
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
	
		$tz = new qCal_Component_Vtimezone(array(
			'tzid' => 'California-Los_Angeles',
			'last-modified' => new qCal_Date(time()),
			'tzurl' => 'http://www.example.com/tz1',
		));
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
	
}
?>