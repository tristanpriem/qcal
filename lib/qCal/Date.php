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
class qCal_Date extends DateTime {

	/**
	 * UTC format string
	 */
	const UTC = "Ymd\THis\Z";
	/**
	 * Used in cases where I need a nice formatted date/time for strtotime
	 */
	const DATETIME = "Y-m-d H:i:s";
	/**
	 * Used in cases where I need a nice formatted date for strtotime
	 */
	const DATE = "Y-m-d";
	/**
	 * Used in cases where I need a nice formatted time for strtotime
	 */
	const TIME = "H:i:s";
	/**
	 * timezone
	 */
	protected $timezone = null;
	/**
	 * Class constructor. This method will accept any date/time format that can be parsed
	 * with the strtotime function.
	 */
	public function __construct($date = null, $timezone = null) {
	
		if ($date instanceof qCal_Date) {
			// if date object was passed in, copy it
			$date = date(self::DATETIME, $date->time());
		} elseif (ctype_digit($date)) {
			// if numerical, then its probably a unix timestamp, treat it as such
			$timestamp = $date;
			$date = date(self::DATETIME, $timestamp);
		} elseif (is_null($date)) {
			$date = "now";
		}
		// in order to not throw a warning for an invalid date format, I have to check that strtotime works properly here
		if (!$timestamp = strtotime($date)) {
			// if unix timestamp can't be created throw an exception
			throw new qCal_Date_Exception_InvalidDate("Invalid or ambiguous date string passed to qCal_Date::setDate()");
		}
		if (is_null($timezone)) $timezone = new DateTimeZone(date_default_timezone_get());
		parent::__construct($date, $timezone);
	
	}
	/**
	 * Returns a unix timestamp
	 */
	public function time() {
	
		return $this->format('U');
	
	}
	/**
	 * Copy a qCal_Date object into this object
	 */
	public function copy(qCal_Date $date) {
	
		$this->setByString($date->format(self::DATETIME));
	
	}
	/**
	 * Set the date/time with a string (using strtotime)
	 */
	public function setByString($str) {
	
		$date = strtotime($str);
		$this->setDate(date('Y', $date), date('m', $date), date('d', $date));
		$this->setTime(date('H', $date), date('i', $date), date('s', $date));
	
	}

}