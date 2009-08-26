<?php
/**
 * This tests the qCal_Date_Recur class thoroughly...
 */
class UnitTestCase_Recur extends UnitTestCase {

	public function setUp() {
	
		// set up and stuff
	
	}
	
	public function tearDown() {
	
		// mr. gorbachev, tear down this wall!!
	
	}
	
	public function testGetInstancesStartMustComeBeforeEnd() {
	
		$recur = new qCal_Date_Recur('yearly');
		$recur->interval(1);
		$this->expectException(new qCal_Date_Exception_InvalidRecur('Start date must come before end date'));
		$dates = $recur->getInstances('08/01/2009', '07/01/2009');
	
	}
	
	public function testGetInstancesRequiresInterval() {
	
		$recur = new qCal_Date_Recur('yearly');
		$this->expectException(new qCal_Date_Exception_InvalidRecur('You must specify an interval'));
		$dates = $recur->getInstances('08/01/2009', '09/01/2009');
	
	}
	
	public function testInvalidFrequency() {
	
		$this->expectException(new qCal_Date_Exception_InvalidRecur('"FOO" is not a valid frequency, must be one of the following: SECONDLY, MINUTELY, HOURLY, DAILY, WEEKLY, MONTHLY, YEARLY'));
		$recur = new qCal_Date_Recur('FOO');
	
	}
	
	public function testGetters() {
	
		$recur = new qCal_Date_Recur('yearly');
		$recur->count(10)
			->byMonth(2)
			->byDay('TU');
		$this->assertEqual($recur->count(), 10);
		$this->assertEqual($recur->byMonth(), array(2));
		$this->assertEqual($recur->byDay(), array('TU'));
		$this->assertEqual($recur->byMonthDay(), null);
	
	}
	
	public function testSetWeekworkStart() {
	
		$recur = new qCal_Date_Recur('minutely');
		$recur->wkst('SU'); // set the work week start to Sunday
		$this->assertEqual($recur->wkst(), 'SU');
		// invalid work day should throw an exception
		$this->expectException(new qCal_Date_Exception_InvalidRecur('"FOO" is not a valid week day, must be one of the following: MO, TU, WE, TH, FR, SA, SU'));
		$recur->wkst('FOO');
	
	}
	
	public function testCanHaveCountOrUntilButNotBoth() {
	
		$rule = new qCal_Date_Recur('hourly');
		$this->expectException(new qCal_Date_Exception_InvalidRecur('A recurrence count and an until date cannot both be specified'));
		$rule->count(10)
			->until('02/12/2009');
	
	}
	
	// public function testBuildRule() {
	// 	
	// 		$recur = new qCal_Date_Recur('yearly');
	// 		$recur->interval(2) // every other year
	// 			->byMonth(1) // every other year in january
	// 			->byDay('SU') // every sunday in january of every other year
	// 			->byHour(array(8,9)) // every sunday in january of every other year at 8am and 9am
	// 			->byMinute(30); // every sunday in january of every other year at 8:30am and 9:30am
	// 		$start = '08/24/1995';
	// 		$end = '08/24/2009';
	// 		$dates = $recur->getInstances($start, $end);
	// 		// pr($dates); // should return an array of qCal_Dates that represent every instance in the timespan
	// 		
	// 	}
	
	/**
	 * Let's start with a really simple rule and go from there...
	 */
	public function testBuildSimpleRule() {
	
		$rule = new qCal_Date_Recur('daily');
		$rule->interval(1);
		// should return every day in august
		$dates = $rule->getInstances('08/01/2009', '09/01/2009');
		// pr($dates);
	
	}

}