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
		$recur = qCal_DateTime_Recur::factory('decadely', 1, $start);
	
	}
	
	public function testFactoryInvalidRecurrenceRuleException() {
	
		$this->expectException(new qCal_DateTime_Exception_InvalidRecurrenceRule("'qCal_Date' is an unsupported recurrence rule."));
		$start = new qCal_DateTime(2012, 1, 1, 12, 0, 0, qCal_Timezone::factory('America/Los_Angeles'));
		$recur = new qCal_DateTime_Recur_Yearly($start, 1, array(new qCal_Date(2012, 1, 15)));
	
	}
	
	public function testFactory() {
	
		$start = new qCal_DateTime(2010, 10, 23, 12, 0, 0, qCal_Timezone::factory('America/Los_Angeles'));
		$recur = qCal_DateTime_Recur::factory('yearly', $start);
		$this->assertIsA($recur, 'qCal_DateTime_Recur_Yearly');
		$this->assertEqual($recur->getStart(), $start);
	
	}
	
	public function testRuleFactory() {
	
		$bymonth = qCal_DateTime_Recur_Rule::factory('month', '1,2,3,4,5,6');
		$this->assertEqual($bymonth, new qCal_DateTime_Recur_Rule_ByMonth(array(1, 2, 3, 4, 5, 6)));
	
	}
	
	public function testYearlyRecurrenceRule() {
	
		$yearly = qCal_DateTime_Recur::factory('yearly', '2010-01-01 12:00am');
		$yearly->addRule(new qCal_DateTime_Recur_Rule_ByMonth(array(1, 3, 5, 7, 9, 11))) // odd months
			->addRule(new qCal_DateTime_Recur_Rule_ByMonthDay(array(5,20))) // on the fifth and twentieth
			->addRule(new qCal_DateTime_Recur_Rule_ByHour(10)) // at 10am
			->addRule(new qCal_DateTime_Recur_Rule_ByMinute(30)); // make that 10:30
		
		// the first recurrence (which will be the first thing returned by current()) should be the date/time below
		// $this->assertEqual($yearly->current(), new qCal_DateTime_Recur_Recurrence(qCal_DateTime::factory('01-05-2010 10:30am')));
	
	}
	
	public function testCurrentReturnsStartObjectIfNoRulesAreApplied() {
	
		$recur = qCal_DateTime_Recur::factory('yearly', '2010');
		// $this->assertEqual($recur->current()->getDateTime(), qCal_DateTime::factory('2010'));
	
	}
	
	public function testRecurrenceCountable() {
	
		$recur = qCal_DateTime_Recur::factory('yearly', '2010-02-04 5:30:30');
		$recur->addRule(new qCal_DateTime_Recur_Rule_ByMinute(array('15', '30', '45')))
			->addRule(new qCal_DateTime_Recur_Rule_BySecond(array('30', '40', '50', '00', '10', '20')))
			->addRule(qCal_DateTime_Recur_Rule::factory('hour', '4,5,1,2,3'))
			->addRule(new qCal_DateTime_Recur_Rule_ByDay(array('-1TU', 'SU')))
			->addRule(new qCal_DateTime_Recur_Rule_ByWeekNo(array('3','25')))
			->addRule(new qCal_DateTime_Recur_Rule_ByMonth(array(1, 2, 3, 4, 5, 6)))
			->addRule(new qCal_DateTime_Recur_Rule_ByMonthDay(array(25, 4, 10)))
			->setCount(500);
		
		// check that current() gets set to the first recurrence
		$this->assertEqual($recur->current()->format('YmdHis'), '20100204011500');
		// check that the countable interface works
		$this->assertEqual(count($recur), 500);
		// check that calling count explicitly works
		$this->assertEqual($recur->count(), 500);
		// check that calling count() rewinds the recurrence pointer
		$this->assertEqual($recur->current()->format('YmdHis'), '20100204011500');
		
		/*$i = 1;
		foreach ($recur as $r) {
			echo "<h1>$i</h1>";
			pr($r->__toString());
			$i++;
		}*/
	
	}
	
	public function testInstantiateWithArrayOfRules() {
	
		$rules = array(
			new qCal_DateTime_Recur_Rule_ByMonth(array(1, 2, 3, 4, 5, 6)),
			new qCal_DateTime_Recur_Rule_ByMonthDay(array(1, 5, 10, 15, 20, 25, 30)),
			new qCal_DateTime_Recur_Rule_ByHour(1),
			new qCal_DateTime_Recur_Rule_ByMinute(30),
			new qCal_DateTime_Recur_Rule_BySetPos(20),
		);
		$recur = new qCal_DateTime_Recur_Yearly('2012', $rules);
		// $this->assertEqual($recur->getRules(), $rules);
	
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