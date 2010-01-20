<?php
/**
 * This tests the qCal_Date_Recur class thoroughly...
 */
class UnitTestCase_Recur extends UnitTestCase {

	public function setUp() {
	
		
	
	}
	
	public function tearDown() {
	
		
	
	}
	
	public function XXXtestRecurPlayground() {
	
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