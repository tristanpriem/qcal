<?php
/**
 * Yearly Date/Time Recurrence object.
 * This class is used to create recurrence rules that happen on a yearly basis.
 * 
 * @package qCal
 * @subpackage qCal_DateTime_Recur
 * @copyright Luke Visinoni (luke.visinoni@gmail.com)
 * @author Luke Visinoni (luke.visinoni@gmail.com)
 * @license GNU Lesser General Public License
 */
class qCal_DateTime_Recur_Yearly extends qCal_DateTime_Recur {

	/**
	 * Move the internal "pointer" to the next recurrence in the set
	 * and return it.
	 * @return qCal_DateTime The next date/time recurrence in the set
	 * @access public
	 */
	public function next() {
	
		// make a copy of the start date/time to work with
		$currentDate = $this->current->getDate();
		$currentTime = $this->current->getTime();
		$year = $this->current->getDate()->getYear();
		
		// create a convenient array of all of our rules so that we don't have to keep
		// calling getRule() all the time.
		$rulesArray = $this->getRulesAsArray();
		
		// if there is no "next" recurrence in the timeArray, we need to
		// regenerate it with new times for the next day in the recurrence list
		if (!$current = next($this->timeArray)) {
			// if there is no "next" day in the yearArray, we need to regenerate
			// the yearArray. It is possible that it hasn't been generated in
			// the first place, so we need to determine if it should be 
			// regenerated for the current year, or for the next year interval
			if (!$currentDay = next($this->yearArray)) {
				// determine if we need to generate the yearArray with the current
				// year or with the next year interval
				if (!empty($this->yearArray)) {
					$year += $this->getInterval();
				}
				// $this->currentDay will be assigned when the yearArray is created
				// we will now need to regenerate the yearArray with the data above
				$this->regenerateYearArray = true;
			} else {
				$this->currentDay = $currentDay;
			}
			// regenerate the timeArray once the yearArray is regenerated
			$this->regenerateTimeArray = true;
		} else {
			$this->current = $current;
		}
		
		// create a multi-dimensional array of dates that will be looped over
		// when the object is looped over. Each date will have one or more 
		// times which will result in even more recurrences. We do not build
		// the time recurrences for the entire year because it takes too long.
		// @todo If this is not the first time we are building this array, we
		// need to skip ahead by $this->interval years. 
		if ($this->regenerateYearArray) {
		
			$yearArray = array();
			for($m = 1; $m <= 12; $m++) {
				$month = new qCal_Date($year, $m, 1);
				for ($d = 1; $d <= $month->getNumDaysInMonth(); $d++) {
					$day = new qCal_Date($year, $m, $d);
					if ($this->checkDateAgainstRules($day)) {
						// if this day is equal to or greater than the current
						// date, add it to the yearArray
						if ($day->getUnixTimestamp() >= $currentDate->getUnixTimestamp()) {
							$yearArray[$day->format("Ymd")] = $day;
						}
					}
				}
			}
			$this->yearArray = $yearArray;
			$this->currentDay = current($this->yearArray);
			// now that we have cached the yearArray, we don't need to
			// regenerate it until we have gotten to the next year increment
			$this->regenerateYearArray = false;
		
		}
		
		// if the time recurrences for the current date haven't been created
		// yet, then create them and assign the "current" value to the first
		// time recurrence in the set. If the time recurrences are already
		// available, move the "current" position ahead one recurrence.
		if ($this->regenerateTimeArray) {
			$this->timeArray = $this->findTimeRecurrences($this->currentDay);
			// now that we have cached the timeArray, we don't need to 
			// regenerate it until we have gotten to the next day
			$this->regenerateTimeArray = false;
			$this->current = current($this->timeArray);
		}
		
		// now find the "next" recurrence, advance the "current" date and
		// return the recurrence
		// @TODO When I come back to this tomorrow, I need to take what I have
		// right now, which is an array of dates that are within the recurrence
		// rule set, along with an array of times on each day, and I need to
		// make this object capable of properly looping over these things.
		
		return $this->current;
		
		/**
		 * This is the old code. It was used to create an array containing twelve arrays (one
		 * for each month) of 28-31 days (one for each day of the month)
		if (empty($this->yearArray) || $regenerateYearArray) {
			$yearArray = array();
			for($m = 1; $m <= 12; $m++) {
				$month = new qCal_Date($currentDate->getYear(), $m, 1);
				$monthArray = array();
				for ($d = 1; $d <= $month->getNumDaysInMonth(); $d++) {
					$day = new qCal_Date($currentDate->getYear(), $m, $d);
					$monthArray[$d] = $day;
				}
				$yearArray[$m] = $monthArray;
			}
			$this->yearArray = $yearArray;
		}
		*/
	
	}
	
	/**
	 * Check a qCal_Date object against all of the rules for this recurrence.
	 * @param qCal_Date The date that needs to be checked against the rules
	 * @return boolean If the rules allow this day, return true
	 * @access protected
	 */
	protected function checkDateAgainstRules(qCal_Date $date) {
	
		$rulesArray = $this->getRulesAsArray();
		// find out if there are any recurrences on this day (week day)
		if (array_key_exists('byDay', $rulesArray)) {
			foreach ($rulesArray['byDay']->getValues() as $wd) {
				$char1 = substr($wd, 0, 1);
				$dtWd = strtoupper(substr($date->getWeekDayName(), 0, 2));
				if (ctype_digit($char1) || $char1 == "-" || $char1 == "+") {
					// if the first character is a digit or a plus or minus, we
					// need to check that date is a specific weekday of the month
					if (preg_match('/([+-]?)([0-9]+)([a-z]+)/i', $wd, $matches)) {
						list($whole, $sign, $dig, $wd) = $matches;
						// find out if this day matches the specific weekday of month
						$xth = (integer) ($sign . $dig);
						// @todo Make sure that getXthWeekDayOfMonth doesn't need
						// to be passed any month or date here...
						$dtWdSpecific = $date->getXthWeekdayOfMonth($xth, $wd);
						if ($dtWdSpecific->__toString() == $date->__toString()) return true;
					}
				} else {
					// otherwise, the value is just a weekday name, so just check that
					if ($wd == $dtWd) {
						return true;
					}
				}
			}
		}
		
		// if the rules specify the date's month
		if (array_key_exists('byMonth', $rulesArray)) {
			foreach ($rulesArray['byMonth']->getValues() as $m) {
				$dtM = $date->getMonth();
				if ($dtM == $m) {
					// and the rules specify the date's day
					if (array_key_exists('byMonthDay', $rulesArray)) {
						foreach ($rulesArray['byMonthDay']->getValues() as $md) {
							$dtMd = $date->getDay();
							if ($md == $dtMd) {
								return true;
							}
						}
					}
					// @todo Check week day like byMonthDay is done above...
				}
			}
		}
		
		// find out if there are any recurrences on this day of the year
		if (array_key_exists('byYearDay', $rulesArray)) {
			foreach ($rulesArray['byYearDay']->getValues() as $yd) {
				$dtYd = $date->getYearDay();
				if ($yd == $dtYd) {
					return true;
				}
			}
		}
		
		// find out if there are any recurrences on this week number
		// @todo I need to make sure that wkst works correctly here
		if (array_key_exists('byWeekNo', $rulesArray)) {
			foreach ($rulesArray['byWeekNo']->getValues() as $wkno) {
				$dtWn = $date->getWeekOfYear();
				if ($dtWn == $wkno) {
					// @todo Should this allow any date that is in the specified week, or just certain days?
					// @todo I can find out by writing unit tests for all of the examples in the RFC
					return true;
				}
			}
		}
		
		return false;
	
	}
	
	/**
	 * Provided a date/time object, use this recurrence's rules to determine
	 * all of the recurrence times for the date and return them in an array.
	 * @param qCal_Date The date object to find time recurrences for
	 * @return array A list of time recurrences for the specified date/time
	 * @access protected
	 * @todo The way this is currently set up allows times before the start
	 * time because this is passed just a date. So when the start date is passed
	 * in, this doesn't know not to return times before the start date.
	 */
	protected function findTimeRecurrences(qCal_Date $date) {
	
		// create a convenient array of the rules so we don't have to
		// keep making lengthy ugly calls to getRule()
		$rulesArray = $this->getRulesAsArray();
		
		// find all of the bySeconds
		$seconds = array();
		if (array_key_exists('bySecond', $rulesArray)) {
			$seconds = $rulesArray['bySecond']->getValues();
			sort($seconds);
		}
		
		// find all of the byMinutes
		$minutes = array();
		if (array_key_exists('byMinute', $rulesArray)) {
			$minutesRules = $rulesArray['byMinute']->getValues();
			sort($minutesRules);
			foreach ($minutesRules as $minute) {
				$minutes[$minute] = $seconds;
			}
		}
		
		// find all of the byHours
		$hours = array();
		if (array_key_exists('byHour', $rulesArray)) {
			$hoursRules = $rulesArray['byHour']->getValues();
			sort($hoursRules);
			foreach ($hoursRules as $hour) {
				$hours[$hour] = $minutes;
			}
		}
		
		// create an array to store times
		$times = array();
		foreach ($hours as $hour => $minutes) {
			foreach ($minutes as $minute => $seconds) {
				foreach ($seconds as $second) {
					try {
						// try to build a date/time object
						$datetime = new qCal_DateTime($date->getYear(), $date->getMonth(), $date->getDay(),  $hour, $minute, $second);
						$times[$datetime->format('YmdHis')] = $datetime;
					} catch (qCal_DateTime_Exception_InvalidTime $e) {	
						// if the date/time object instantiation fails, this exception will be thrown
						// @todo Recover from this error and report it. Maybe catch the error and pass it to a log or something?
						// qCal_Log::logException($e, get_class($this));
						throw $e;
					}
				}
			}
		}
		
		return $times;
	
	}

}