<?php
class qCal_Date_Recur_Monthly extends qCal_Date_Recur_Helper {

	/**
	 * 
	 */
	public function increment($increment) {
	
		$increment = (integer) $increment;
		$this->datetime->modify("+$increment months");
	
	}
	/**
	 * 
	 */
	public function onOrBefore($date) {
	
		$date = new qCal_Date($date);
		// we can return true right off the bat if BEFORE, but same month takes a bit of work
		if ($this->datetime->time() < $date->time()) return true;
		// if the date falls within the week or before, return true
		$month = $date->format('m/d/Y');
		if ($this->datetime->format('m/d/Y') == $month) {
			return true;
		}
		return false;
	
	}

}