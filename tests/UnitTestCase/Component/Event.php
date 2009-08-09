<?php
class UnitTestCase_Component_Event extends UnitTestCase {

	/**
	 *              ; either 'dtend' or 'duration' may appear in
	 *              ; a 'eventprop', but 'dtend' and 'duration'
	 *              ; MUST NOT occur in the same 'eventprop'
	 */
	public function testDtendOrDurationMayAppearButNotBoth() {
	
		$this->expectException(new qCal_Exception_InvalidProperty('DTEND and DURATION cannot both occur in the same VEVENT component'));
		$event = new qCal_Component_Vevent(array(
			'dtend' => '20090101T040000Z',
			'duration' => 'P1D'
		));
	
	}
	/**
	 * Example: The following is an example of the "VEVENT" calendar
	 * component used to represent a meeting that will also be opaque to
	 * searches for busy time:
	 * 
	 *   BEGIN:VEVENT
	 *   UID:19970901T130000Z-123401@host.com
	 *   DTSTAMP:19970901T1300Z
	 *   DTSTART:19970903T163000Z
	 *   DTEND:19970903T190000Z
	 *   SUMMARY:Annual Employee Review
	 *   CLASS:PRIVATE
	 *   CATEGORIES:BUSINESS,HUMAN RESOURCES
	 *   END:VEVENT
	 */
	public function testMeetingThatWillBeOpaqueToSearchesForBusyTime() {
	
		$event = new qCal_Component_Vevent(array(
			'uid' => '19970901T130000Z-123401@host.com',
			'dtstamp' => '19970901T1300Z',
			'dtstart' => '19970903T163000Z',
			'dtend' => '19970903T190000Z',
			'summary' => 'Annual Employee Review',
			'class' => 'PRIVATE',
			'categories' => array('BUSINESS','HUMAN RESOURCES'),
		));
	
	}

}
?>