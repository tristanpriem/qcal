<?php
/**
 * This tests the qCal_Date_Recur class thoroughly...
 */
class UnitTestCase_Recur extends UnitTestCase {

	public function setUp() {
	
		
	
	}
	
	public function tearDown() {
	
		
	
	}
	
	public function testFactoryInvalidRecurrenceFrequencyException() {
	
		$this->expectException(new qCal_DateTime_Exception_InvalidRecurrenceFrequency("'decadely' is an unsupported recurrence frequency."));
		$start = new qCal_DateTime(2010, 10, 23, 12, 0, 0, qCal_Timezone::factory('America/Los_Angeles'));
		$recur = qCal_DateTime_Recur::factory('decadely', $start);
	
	}
	
	public function testFactoryInvalidRecurrenceRuleException() {
	
		$this->expectException(new qCal_DateTime_Exception_InvalidRecurrenceRule("'01/15/2012' is an unsupported recurrence rule."));
		$start = new qCal_DateTime(2012, 1, 1, 12, 0, 0, qCal_Timezone::factory('America/Los_Angeles'));
		$recur = new qCal_DateTime_Recur_Yearly($start, array(new qCal_Date(2012, 1, 15)));
	
	}
	
	public function testFactory() {
	
		$start = new qCal_DateTime(2010, 10, 23, 12, 0, 0, qCal_Timezone::factory('America/Los_Angeles'));
		$recur = qCal_DateTime_Recur::factory('yearly', $start);
		$this->assertIsA($recur, 'qCal_DateTime_Recur_Yearly');
		$this->assertEqual($recur->getStart(), $start);
	
	}
	
	
	public function XXXtestRecurPlayground() {
	
		$this->yearly = new qCal_DateTime_Recur_Yearly("2008-01-01 12:00am");
		$this->yearly->interval(2) // every other year
			->byDay("SU,MO,TU") // on every sunday, monday and tuesday
			->byMonth("1,3,5,7,9,11") // in every other month
			->byHour("1") // at 1 o'clock
			->byMinute("30") // make that at 1:30
			->until("2012"); // until 2012
		
		/**
		 * For yearly rules, just about any type of modifier is going to increase the number
		 * of recurrences.
		 */
		$start = "10-23-2009 12:00:00";
		$yearly = new qCal_DateTime_Recur_Yearly($start); // starting from this date
		$yearly->interval(1) // every year
			   ->byWeekday("Sunday", -1) // on every last sunday
			   ->byMonth("2,3,4") // of february, march, and april 
			   ->until("2012"); // until 2012
		
		/**
		 * Monthly rules are similar to yearly rules
		 */
		$monthly = new qCal_DateTime_Recur_Monthly($start);
		$monthly->interval(3) // every three months
				->byDay(15) // on the fifteenth of the month
				->byHour(3) // at three
				->byMinute(30) // make that three thirty
				->count(15); // for 15 occurrances
		
		/**
		 * For weekly rules, byMonth and byYear will reduce the amount of occurrences
		 * while all others will increase them (or at least not decrease them)
		 */
		$weekly = new qCal_DateTime_Recur_Weekly($start);
		$weekly->interval(1) // every week
			   ->byWeekday(1) // on Monday
			   ->byHour(10) // at 10:00
			   ->until("12-21-2011");
		
		/**
		 * Daily rules
		 */
		$daily = new qCal_DateTime_Recur_Daily($start);
		$daily->interval(1) // every day
			  ->byMonth(6) // in June
			  ->byHour(10); // at 10:00
		
		$hourly = new qCal_DateTime_Recur_Hourly($start);
		$hourly->interval(4) // every four hours
			   ->byMonth("1,2,3,4,5,6") // from january to june
			   ->until(2012); // until 2012
		
		$minutely = new qCal_DateTime_Recur_Minutely($start);
		$minutely->interval(30); // every thirty minutes
		
		$secondly = new qCal_DateTime_Recur_Secondly($start);
		$secondly->interval(30) // every thirty seconds
				 ->byWeekday("Sunday", "1,2,3") // on the first, second, and third sundays
				 ->byMonth(1) // in January
				 ->count(1000); // for a thousand occurrances
	
	}

}