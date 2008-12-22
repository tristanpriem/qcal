<?php
/**
 * Date Timezone object
 * 
 * @package qCal
 * @subpackage qCal_Date
 * @copyright Luke Visinoni (luke.visinoni@gmail.com)
 * @author Luke Visinoni (luke.visinoni@gmail.com)
 * @license GNU Lesser General Public License
 */
class qCal_Date_Timezone {

	/**
	 * Contains a list of time zone information (names, abbreviations, etc.)
	 */
	protected $timezones;
	public function __construct($timezone = null) {
	
		$this->timezones = timezone_abbreviations_list();
		$this->setTimezone($timezone);
	
	}
	public function setTimezone($timezone = null) {
	
		if (is_null($timezone)) {
			$timezone = date_default_timezone_get();
		}
		$this->timezone = $timezone;
		return $this;
	
	}
	public function __toString() {
	
		return $this->timezone;
	
	}

}