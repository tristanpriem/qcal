<?php
/**
 * Base date object. Stores date information only (without a time). Internally the date is stored as a
 * unix timestamp, but the time portion of it is not used. If you need a date with a time, use qCal_DateTime
 * @package qCal
 * @subpackage qCal_Date
 * @copyright Luke Visinoni (luke.visinoni@gmail.com)
 * @author Luke Visinoni (luke.visinoni@gmail.com)
 * @license GNU Lesser General Public License
 * @todo Create a setDateByString method for things such as "The day after tomorrow"
 */
class qCal_DateV2 {

	/**
	 * @var unix timestamp
	 */
	protected $date;
	/**
	 * @var array The results of a getdate() call
	 */
	protected $dateArray;
	/**
	 * Class constructor
	 * @param int The year of this date
	 * @param int The month of this date
	 * @param int The day of this date
	 */
	public function __construct($year = null, $month = null, $day = null) {
	
		$this->setDate($year, $month, $day);
	
	}
	/**
	 * Set the date of this class
	 * The date defaults to now. If any part of the date is missing, it will default to whatever "now"'s
	 * date portion is. For instance, if the year provided is 2006 and no other portion is given, it will
	 * default to today's month and day, but in the year 2006. If, for any reason the date defaults to a 
	 * nonsensical date, an exception will be thrown. For instance, if you specify the year as 2006, and
	 * the current date is february 29th, an exception will be thrown because the 29th of February does not
	 * exist in 2006. 
	 * @param int The year of this date
	 * @param int The month of this date
	 * @param int The day of this date
	 * @throws qCal_Date_Exception_InvalidDate
	 */
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
		$this->dateArray = getdate($this->date);
	
	}
	
	public function getMonth() {
	
		return $this->dateArray["mon"];
	
	}
	
	public function getDay() {
	
		return $this->dateArray["mday"];
	
	}
	
	public function getYear() {
	
		return $this->dateArray["year"];
	
	}

}