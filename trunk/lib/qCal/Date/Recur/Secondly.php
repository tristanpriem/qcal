<?php
class qCal_Date_Recur_Secondly extends qCal_Date_Recur_Helper {

	/**
	 * 
	 */
	public function increment($increment) {
	
		$increment = (integer) $increment;
		$this->datetime->modify("+$increment seconds");
	
	}
	/**
	 * 
	 */
	public function onOrBefore($date) {
	
		$date = new qCal_Date($date);
		return ($this->datetime->time() <= $date->time());
	
	}

}