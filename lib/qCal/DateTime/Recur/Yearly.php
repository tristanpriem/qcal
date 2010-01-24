<?php
/**
 * Yearly rules should be fairly easy because we can start with every year
 * on the date that is passed to the constructor. Then for each type of byXXX
 * that is added, we simply add more dates (or keep the same amount) that will
 * be in the results. The exception is bySetPos, which will usually reduce the
 * amount of recurrences no matter what.
 */
class qCal_DateTime_Recur_Yearly extends qCal_DateTime_Recur {

	public function getRecurrenceSubset() {
	
		$start = $this->getStart();
		
		// generate the list of bySecond rules
		if ($this->bySecond()) {
			$seconds = $this->ruleset->getRule("Second");
		} else {
			$seconds = new qCal_DateTime_Recur_Rule_Second($start->getTime()->getSecond());
		}
		
		// generate the list of byMinute rules
		if ($this->byMinute()) {
			$minutes = $this->ruleset->getRule("Minute");
		} else {
			$minutes = new qCal_DateTime_Recur_Rule_Minute($start->getTime()->getMinute());
		}
		
		// generate the list of byHour rules
		if ($this->byHour()) {
			$hours = $this->ruleset->getRule("Hour");
		} else {
			$hours = new qCal_DateTime_Recur_Rule_Hour($start->getTime()->getHour());
		}
		
		// generate the list of byMonthDay
		if ($this->byMonthDay()) {
			$monthdays = $this->ruleset->getRule("MonthDay");
		} else {
			$monthdays = new qCal_DateTime_Recur_Rule_MonthDay($start->getDate()->getDay());
		}
		
		// genereate the list of byMonth
		if ($this->byMonth()) {
			$months = $this->ruleset->getRule("Month");
		} else {
			$months = new qCal_DateTime_Recur_Rule_Month($start->getDate()->getMonth());
		}
		
		// starting over...
	
	}

}