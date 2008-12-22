<?php
/**
 * Date object - this is a very rudimentary date/time class. Eventually I would like to 
 * rewrite it to be much more useful. I want it to eventually support a much wider date range
 * as well as "floating" dates... dates with no time associated with them. Basically I'd like to
 * not have to rely on unix timestamps
 * 
 * qCal_Value_Date, qCal_Value_DateTime, qCal_Value_Time and any other datatypes that represent
 * date/time information will use this object to store that information.
 * 
 * @package qCal
 * @subpackage qCal_Date
 * @copyright Luke Visinoni (luke.visinoni@gmail.com)
 * @author Luke Visinoni (luke.visinoni@gmail.com)
 * @license GNU Lesser General Public License
 */
class qCal_Date {

	/**
	 * Contains 4-digit year
	 */
	protected $year = null;
	/**
	 * 2-digit month
	 */
	protected $month = null;
	/**
	 * 2-digit day
	 */
	protected $day = null;
	/**
	 * 2-digit hour
	 */
	protected $hour = null;
	/**
	 * 2-digit minute
	 */
	protected $minute = null;
	/**
	 * 2-digit second
	 */
	protected $second = null;
	/**
	 * timezone
	 */
	protected $timezone = null;
	/**
	 * used in the time() method.. instead of regenerating a timestamp every time, it's stored in this var
	 */
	protected $timestamp = null;
	/**
	 * Class constructor. This method will accept any date/time format that can be parsed
	 * with the strtotime function.
	 */
	public function __construct($date = null) {
	
		$this->setDate($date);
	
	}
	/**
	 * Set date/time. This method will accept any date/time format that can be parsed
	 * with the strtotime function. Defaults to now.
	 */
	public function setDate($date = null) {
	
		if (is_null($date)) {
			$date = "now";
		}
		// if date isn't a unix timestamp, make it one
		if (!ctype_digit($date)) {
			if (!$date = strtotime($date)) {
				// if unix timestamp can't be created throw an exception
				throw new qCal_Exception_InvalidDate("Invalid or ambiguous date string passed to qCal_Date::setDate()");
			}
		}
		$datetime = getdate($date);
		$this->year = $datetime['year'];
		$this->month = $datetime['mon'];
		$this->day = $datetime['mday'];
		$this->hour = $datetime['hours'];
		$this->minute = $datetime['minutes'];
		$this->second = $datetime['seconds'];
		$this->timezone = null;
		// for fluidity
		return $this;
	
	}
	/**
	 * Returns a unix timestamp
	 */
	public function time() {
	
		if (is_null($this->timestamp)) {
			$this->timestamp = mktime(
				$this->hour,
				$this->minute,
				$this->second,
				$this->month,
				$this->day,
				$this->year
			);
		}
		return $this->timestamp;
	
	}
	/**
	 * Formats the date using php's date() function
	 */
	public function format($str) {
	
		return date($str, $this->time());
	
	}

}