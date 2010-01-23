<?php
abstract class qCal_DateTime_Recur {

	protected $start;
	
	protected $interval;
	
	protected $until;
	
	protected $ruleset;
	
	public function __construct($start) {
	
		if (!($start instanceof qCal_DateTime)) {
			$start = qCal_DateTime::factory($start);
		}
		$this->start = $start;
		$this->ruleset = new qCal_DateTime_Recur_Set($this);
	
	}
	
	public function getStart() {
	
		return $this->start;
	
	}
	
	/**
	 * The following are getters and setters (both use the same method)
	 */
	
	public function interval($interval = null) {
	
		if (is_null($interval)) return $this->interval;
		$this->interval = (integer) $interval;
		return $this;
	
	}
	
	public function until($until = null) {
	
		if (is_null($until)) return $this->until;
		if (!($until instanceof qCal_DateTime)) {
			$until = qCal_DateTime::factory($until);
		}
		$this->until = $until;
	
	}
	
	public function byDay($day = null) {
	
		if (is_null($day)) {
			$day = $this->ruleset->getRule("Day");
			if ($day instanceof qCal_DateTime_Recur_Rule_Day) return $day->__toString();
			else return false;
		}
		// this object does things like convert "1SU" to "The first sunday of the month"
		// or -2MO to "the second to last monday"
		// needs access to $this so that it can use data from this object
		$byday = new qCal_DateTime_Recur_Rule_Day($day);
		// add the newly created object to the chain of recurrence rules
		$this->ruleset->addRule($byday);
		return $this;
	
	}
	
	public function byHour($hour = null) {
	
		if (is_null($hour)) {
			$hour = $this->ruleset->getRule("Hour");
			if ($hour instanceof qCal_DateTime_Recur_Rule_Hour) return $hour->__toString();
			else return false;
		}
		$byhour = new qCal_DateTime_Recur_Rule_Hour($hour);
		$this->ruleset->addRule($byhour);
		return $this;
	
	}
	
	public function byMinute($minute = null) {
	
		if (is_null($minute)) {
			$minute = $this->ruleset->getRule("Minute");
			if ($minute instanceof qCal_DateTime_Recur_Rule_Minute) return $minute->__toString();
			else return false;
		}
		$byminute = new qCal_DateTime_Recur_Rule_Minute($minute);
		$this->ruleset->addRule($byminute);
		return $this;
	
	}
	
	public function byMonth($month = null) {
	
		if (is_null($month)) {
			$month = $this->ruleset->getRule("Month");
			if ($month instanceof qCal_DateTime_Recur_Rule_Month) return $month->__toString();
			else return false;
		}
		$bymonth = new qCal_DateTime_Recur_Rule_Month($month);
		$this->ruleset->addRule($bymonth);
		return $this;
	
	}
	
	public function byMonthDay($monthday = null) {
	
		if (is_null($monthday)) {
			$monthday = $this->ruleset->getRule("MonthDay");
			if ($monthday instanceof qCal_DateTime_Recur_Rule_MonthDay) return $monthday->__toString();
			else return false;
		}
		$bymonthday = new qCal_DateTime_Recur_Rule_MonthDay($monthday);
		$this->ruleset->addRule($bymonthday);
		return $this;
	
	}
	
	public function bySetPos($setpos = null) {
	
		if (is_null($setpos)) {
			$setpos = $this->ruleset->getRule("SetPos");
			if ($setpos instanceof qCal_DateTime_Recur_Rule_SetPos) return $setpos->__toString();
			else return false;
		}
		$bysetpos = new qCal_DateTime_Recur_Rule_SetPos($setpos);
		$this->ruleset->addRule($bysetpos);
		return $this;
	
	}
	
	public function byWeekNo($weekno = null) {
	
		if (is_null($weekno)) {
			$weekno = $this->ruleset->getRule("WeekNo");
			if ($weekno instanceof qCal_DateTime_Recur_Rule_WeekNo) return $weekno->__toString();
			else return false;
		}
		$byweekno = new qCal_DateTime_Recur_Rule_Day($weekno);
		$this->ruleset->addRule($byweekno);
		return $this;
	
	}
	
	public function getRecurrences() {
	
		// generate the list of dates/times and create the following iterator
		// another option would be to pass all of the appropriate information
		// for how to find the previous, next, current date to the iterator
		// and let it figure out the dates/times itself.
		return $this->ruleset;
	
	}

}