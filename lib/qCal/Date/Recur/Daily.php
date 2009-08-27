<?php
class qCal_Date_Recur_Daily extends qCal_Date_Recur_Helper {

	/**
	 * 
	 */
	public function increment($increment) {
	
		$increment = (integer) $increment;
		$this->datetime->modify("+$increment days");
	
	}
	/**
	 * 
	 */
	public function onOrBefore($date) {
	
		$date = new qCal_Date($date);
		// we can return true right off the bat if BEFORE, but same day takes a bit of work
		if ($this->datetime->time() < $date->time()) return true;
		// if the date falls within the hour or before, return true
		$day = $date->format('m/d/Y');
		if ($this->datetime->format('m/d/Y') == $day) {
			return true;
		}
		return false;
	
	}

}