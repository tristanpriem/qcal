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
	 * UTC format string
	 */
	const UTC = "Ymd\THis\Z";
	/**
	 * timezone
	 */
	protected $timezone = null;
	/**
	 * for now, we will use timestamps
	 * this timestamp is saved as GMT and then adjusted based on timestamp
	 */
	protected $timestamp = null;
	/**
	 * Class constructor. This method will accept any date/time format that can be parsed
	 * with the strtotime function.
	 */
	public function __construct($date = null, $timezone = null) {
	
		$this->setDate($date);
	
	}
	/**
	 * Set date/time. This method will accept any date/time format that can be parsed
	 * with the strtotime function. Defaults to now.
	 */
	public function setDate($date = null) {
	
		if ($date instanceof qCal_Date) {
			// if date object was passed in, copy it
			$this->copy($date);
		} elseif (ctype_digit($date)) {
			// if numerical, then its probably a unix timestamp, treat it as such
			$this->timestamp = $date;
		} else {
			// otherwise, attempt to convert with strtotime
			if (is_null($date)) {
				// if no date was passed in, use now
				$date = "now";
			}
			if (!$this->timestamp = strtotime($date)) {
				// @todo 
				// strtotime and other php date/time functions rely on the timezone set via date_default_timezone_set()
				// in their date/time calculations, so we need to set the default timezone to GMT and adjust manually
				// if unix timestamp can't be created throw an exception
				throw new qCal_Date_Exception_InvalidDate("Invalid or ambiguous date string passed to qCal_Date::setDate()");
			}
		}
		$this->timezone = null;
		// for fluidity
		return $this;
	
	}
	/**
	 * Returns a unix timestamp
	 */
	public function time() {
	
		return $this->timestamp;
	
	}
	/**
	 * Formats the date using php's date() function
	 */
	public function format($str) {
	
		return date($str, $this->time());
	
	}
	/**
	 * Copy a qCal_Date object into this object
	 */
	public function copy(qCal_Date $date) {
	
		$this->setDate($date->time());
	
	}

}