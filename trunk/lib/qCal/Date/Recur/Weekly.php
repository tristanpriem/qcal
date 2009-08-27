<?php
class qCal_Date_Recur_Weekly extends qCal_Date_Recur_Helper {

	/**
	 * 
	 */
	public function increment($increment) {
	
		$increment = (integer) $increment;
		$this->datetime->modify("+$increment weeks");
	
	}
	/**
	 * @todo This probably isn't right every time since I used the day here... I dunno. I'm tired.
	 */
	public function onOrBefore($date) {
	
		$date = new qCal_Date($date);
		// we can return true right off the bat if BEFORE, but same week takes a bit of work
		if ($this->datetime->time() < $date->time()) return true;
		// if the date falls within the week or before, return true
		$day = $date->format('m/d/Y');
		if ($this->datetime->format('m/d/Y') == $day) {
			return true;
		}
		return false;
	
	}

}