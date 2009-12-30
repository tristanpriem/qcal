<?php
/**
 * qCal_DateTime
 * 
 * In order to perform all the complex date/time based math and logic required to
 * implement the iCalendar spec, we need a complex date/time class. This class represents
 * a specific point in time, including the time. Internally it makes use of qCal_DateV2 and
 * qCal_Time. If only a date or only a time needs to be represented, then one of those
 * classes should be used.
 * 
 * @package qCal_DateV2
 * @
 */
class qCal_DateTime {

	/**
	 * @var qCal_DateV2 An object that represents the date
	 */
	protected $date;
	/**
	 * @var qCal_Time An object that represents the time
	 */
	protected $time;
	/**
	 * @var string The default string representation of datetime is a direct
	 * correlation to the date function's "c" metacharacter
	 */
	protected $format = "Y-m-d\TH:i:s";
	/**
	 * Class constructor
	 * @todo Make this default to "now"
	 * @todo It is possible that the timezone could put the date back (or forward?) a day. This does not account for that
	 */
	public function __construct($year, $month, $day, $hour, $minute, $second, $timezone = null, $rollover = null) {
	
		$date = new qCal_DateV2($year, $month, $day, $rollover);
		$time = new qCal_Time($hour, $minute, $second, $timezone, $rollover);
		$this->setDate($date);
		$this->setTime($time);
	
	}
	/**
	 * Generate a datetime object via string
	 */
	public static function factory($datetime, $timezone = null) {
	
		if (is_null($timezone) || !($timezone instanceof qCal_Timezone)) {
			$timezone = qCal_Timezone::factory($timezone);
		}
		// get the default timezone so we can set it back to it later
		$tz = date_default_timezone_get();
		// set the timezone to GMT temporarily
		date_default_timezone_set("GMT");
		
		if (is_integer($datetime)) {
			// @todo Handle timestamps
		}
		if (is_string($datetime)) {
			if (!$timestamp = strtotime($datetime)) {
				// if unix timestamp can't be created throw an exception
				throw new qCal_DateTime_Exception("Invalid or ambiguous date/time string passed to qCal_DateTime::factory()");
			}
		}
		list($year, $month, $day, $hour, $minute, $second) = explode("|", gmdate("Y|m|d|H|i|s", $timestamp));
		
		// set the timezone back to what it was
		date_default_timezone_set($tz);
		
		return new qCal_DateTime($year, $month, $day, $hour, $minute, $second, $timezone);
	
	}
	/**
	 * Set the date component
	 */
	protected function setDate(qCal_DateV2 $date) {
	
		$this->date = $date;
	
	}
	/**
	 * Set the time component
	 */
	protected function setTime(qCal_Time $time) {
	
		$this->time = $time;
	
	}
	/**
	 * Set the timezone
	 */
	public function setTimezone($timezone) {
	
		$this->time->setTimezone($timezone);
	
	}
	/**
	 * Get Year
	 */
	public function getYear() {
	
		return $this->date->getYear();
	
	}
	/**
	 * Get Month
	 */
	public function getMonth() {
	
		return $this->date->getMonth();
	
	}
	/**
	 * Get Day
	 */
	public function getDay() {
	
		return $this->date->getDay();
	
	}
	/**
	 * Get Hour
	 */
	public function getHour() {
	
		return $this->time->getHour();
	
	}
	/**
	 * Get Minute
	 */
	public function getMinute() {
	
		return $this->time->getMinute();
	
	}
	/**
	 * Get Second
	 */
	public function getSecond() {
	
		return $this->time->getSecond();
	
	}
	/**
	 * Get Timezone
	 */
	public function getTimezone() {
	
		return $this->time->getTimezone();
	
	}
	/**
	 * Get unix timestamp
	 */
	public function getUnixTimestamp($useOffset = false) {
	
		return $this->date->getUnixTimestamp() + $this->time->getTimestamp($useOffset);
	
	}
	/**
	 * Format the date/time using PHP's date() function's meta-characters
	 * @todo It's obvious I need to find a better solution to formatting since I have repeated this method
	 * in three classes now...
	 */
	public function format($format) {
	
		$escape = false;
		$meta = str_split($format);
		$output = array();
		foreach($meta as $char) {
			if ($char == '\\') {
				$escape = true;
				continue;
			}
			if (!$escape && $this->convertChar($char) != $char) {
				$output[] = $this->convertChar($char);
			} else {
				$output[] = $char;
			}
			// reset this to false after every iteration that wasn't "continued"
			$escape = false;
		}
		return implode($output);
	
	}
	/**
	 * convert character
	 */
	protected function convertChar($char) {
	
		$char = $this->date->format($char);
		$char = $this->time->format($char);
		return $char;
	
	}
	/**
	 * Output date/time as string
	 */
	public function __toString() {
	
		return $this->format($this->format);
	
	}
	/**
	 * Get date/time as UTC
	 */
	public function getUtc() {
	
		// format date/time in UTC
		// @todo I would prefer to use $this->format() for this, but the way it currently works makes it impossible
		// @todo This is soooo sloppy... I think it's due to the fact that I am calculating the offset incorrectly in getTimestamp()
		return gmdate("Ymd", $this->date->getUnixTimestamp()) . gmdate("\THis\Z", $this->time->getTimestamp() - $this->time->getTimezone()->getOffsetSeconds());
	
	}

}