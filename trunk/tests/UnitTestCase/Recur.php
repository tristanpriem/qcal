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
	/**
	 * Within the recur object, we use objects to compare the current date with
	 * rule modifiers. This tests their functionality.
	 */
	public function testLoopHelpers() {
	
		// let's assume we want a recurrence every 30 seconds starting from 01/01/2000 at 12:00am
		// and ending at 01/01/2000 at 12:05:15am
		$sInstances = array();
		$secondly = new qCal_Date_Recur_Secondly('01/01/2000 12:00am');
		while($secondly->onOrBefore('01/01/2000 12:05:15am')) {
			// get current instance
			$sInstances[] = $secondly->getInstance();
			// increment by 30 seconds
			$secondly->increment(30);
		}
		
		// make sure onOrBefore works right
		$on = new qCal_Date('01/01/2000 12:00am');
		$after = new qCal_Date('01/01/2000 12:00:01am');
		$before = new qCal_Date('12/31/1999 11:59:59pm');
		$sly = new qCal_Date_Recur_Secondly('01/01/2000 12:00am');
		$this->assertTrue($sly->onOrBefore($on));
		$this->assertTrue($sly->onOrBefore($after));
		$this->assertFalse($sly->onOrBefore($before));
		
		$this->assertEqual($sInstances, array(
			new qCal_Date('01/01/2000 12:00am'),
			new qCal_Date('01/01/2000 12:00:30am'),
			new qCal_Date('01/01/2000 12:01am'),
			new qCal_Date('01/01/2000 12:01:30am'),
			new qCal_Date('01/01/2000 12:02am'),
			new qCal_Date('01/01/2000 12:02:30am'),
			new qCal_Date('01/01/2000 12:03am'),
			new qCal_Date('01/01/2000 12:03:30am'),
			new qCal_Date('01/01/2000 12:04am'),
			new qCal_Date('01/01/2000 12:04:30am'),
			new qCal_Date('01/01/2000 12:05am'),
		));
		
		// let's assume we want a recurrence every 20 minutes starting from 01/01/2000 at 12:00am
		// and ending at 01/01/2000 at 3:50:15am
		$minInstances = array();
		$minutely = new qCal_Date_Recur_Minutely('01/01/2000 12:00am');
		while($minutely->onOrBefore('01/01/2000 3:50:15am')) {
			// get current instance
			$minInstances[] = $minutely->getInstance();
			// increment by 30 seconds
			$minutely->increment(20);
		}
		
		// make sure onOrBefore works right
		$on = new qCal_Date('01/01/2000 12:00:20am');
		$after = new qCal_Date('01/01/2000 12:02:00am');
		$before = new qCal_Date('12/31/1999 11:59:59pm');
		$mly = new qCal_Date_Recur_Minutely('01/01/2000 12:00am');
		$this->assertTrue($mly->onOrBefore($on));
		$this->assertTrue($mly->onOrBefore($after));
		$this->assertFalse($mly->onOrBefore($before));
		
		$this->assertEqual($minInstances, array(
			new qCal_Date('01/01/2000 12:00am'),
			new qCal_Date('01/01/2000 12:20am'),
			new qCal_Date('01/01/2000 12:40am'),
			new qCal_Date('01/01/2000 01:00am'),
			new qCal_Date('01/01/2000 01:20am'),
			new qCal_Date('01/01/2000 01:40am'),
			new qCal_Date('01/01/2000 02:00am'),
			new qCal_Date('01/01/2000 02:20am'),
			new qCal_Date('01/01/2000 02:40am'),
			new qCal_Date('01/01/2000 03:00am'),
			new qCal_Date('01/01/2000 03:20am'),
			new qCal_Date('01/01/2000 03:40am'),
		));
	
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
	// public function testBuildSimpleRule() {
	// 
	// 	$rule = new qCal_Date_Recur('daily');
	// 	$rule->interval(1);
	// 	// should return every day in august
	// 	$dates = $rule->getInstances('08/01/2009', '09/01/2009');
	// 	// pr($dates);
	// 
	// }

}