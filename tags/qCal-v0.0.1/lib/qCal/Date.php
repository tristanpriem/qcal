<?php
/**
 * qCal_Date
 * This class is used throughout qCal to represent dates and times. It was written
 * to adhere to ISO 8601 standards.
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
		// pr($date);
		if (!$timestamp = strtotime($date)) {
			// if unix timestamp can't be created throw an exception
			throw new qCal_DateTime_Exception_InvalidDate("Invalid or ambiguous date string passed to qCal_Date::setDate()");
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
		return $this;
	
	}
	/**
	 * Set the date/time with a string (using strtotime)
	 */
	public function setByString($str) {
	
		$date = strtotime($str);
		$this->setDate(date('Y', $date), date('m', $date), date('d', $date));
		$this->setTime(date('H', $date), date('i', $date), date('s', $date));
		return $this;
	
	}
	/**
	 * Surprising there is no __toString built-in
	 * @todo Test this
	 */
	public function __toString() {
	
		return $this->getUtc();
	
	}
	/**
	 * Returns time formatted in UTC
	 */
	public function getUtc() {
	
		return gmdate(self::UTC, $this->time());
	
	}

}