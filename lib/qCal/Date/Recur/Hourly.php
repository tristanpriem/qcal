<?php
class qCal_Date_Recur_Hourly extends qCal_Date_Recur_Helper {

	/**
	 * 
	 */
	public function increment($increment) {
	
		$increment = (integer) $increment;
		$this->datetime->modify("+$increment hours");
	
	}
	/**
	 * 
	 */
	public function onOrBefore($date) {
	
		$date = new qCal_Date($date);
		// we can return true right off the bat if BEFORE, but SAME hour takes a bit of work
		if ($this->datetime->time() < $date->time()) return true;
		// if the date falls within the hour or before, return true
		$day = $date->format('m/d/Y');
		if ($this->datetime->format('m/d/Y')) {
			// same day, so continue
			if ($this->datetime->format('H') == $date->format('H')) return true;
		}
		return false;
	
	}

}