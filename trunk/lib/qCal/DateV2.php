<?php
/**
 * Base date object. Stores date information only (without a time). Internally the date is stored as a
 * unix timestamp, but the time portion of it is not used. If you need a date with a time, use qCal_DateTime
 * @package qCal
 * @subpackage qCal_Date
 * @copyright Luke Visinoni (luke.visinoni@gmail.com)
 * @author Luke Visinoni (luke.visinoni@gmail.com)
 * @license GNU Lesser General Public License
 */
class qCal_DateV2 {

	protected $date;
	
	public function __construct($year = null, $month = null, $day = null) {
	
		$this->setDate($year, $month, $day);
	
	}
	
	public function setDate($year = null, $month = null, $day = null) {
	
		$now = getdate();
		if (is_null($year)) {
			$year = $now['year'];
		}
		if (is_null($month)) {
			$month = $now['mon'];
		}
		if (is_null($day)) {
			$day = $now['mday'];
		}
		$this->date = mktime(0, 0, 0, $month, $day, $year);
	
	}
	
	public function format($format) {
	
		return date($format, $this->date);
	
	}

}