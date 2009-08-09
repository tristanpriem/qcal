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

}
?>