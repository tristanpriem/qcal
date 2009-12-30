<?php
class qCal_Time {

	/**
	 * Timestamp
	 */
	protected $time;
	/**
	 * The default format that time is output as
	 */
	protected $format = "H:i:s";
	/**
	 * The timezone
	 */
	protected $timezone;
	/**
	 * Time array (contains hour, minute, second, etc.)
	 */
	protected $timeArray = array();
	/**
	 * Class constructor
	 * This component is immutable. It can only be created, not modified. The only portion of it that
	 * can be modified is the timezone.
	 */
	public function __construct($hour, $minute, $second, $timezone = null, $rollover = null) {
	
		$this->setTimezone($timezone)
			 ->setTime($hour, $minute, $second, $rollover);
	
	}
	/**
	 * Set the time
	 * @access protected This class is immutable, so this is protected. Only the constructor calls it.
	 */
	protected function setTime($hour, $minute, $second, $rollover = null) {
	
		if (is_null($rollover)) $rollover = false;
		if (!$rollover) {
			if ($hour > 23 || $minute > 59 || $second > 59) {
				throw new qCal_DateTime_Exception_InvalidTime(sprintf("Invalid time specified for qCal_Time: \"%02d:%02d:%02d\"", $hour, $minute, $second));
			}
		}
		// since PHP is incapable of storing a time without a date, we use the first day of
		// the unix epoch so that we only have the amount of seconds since the zero of unix epoch
		$time = gmmktime($hour, $minute, $second, 1, 1, 1970);
		$formatString = "a|A|B|g|G|h|H|i|s|u";
		$keys = explode("|", $formatString);
		$vals = explode("|", gmdate($formatString, $time));
		$this->timeArray = array_merge($this->timeArray, array_combine($keys, $vals));
		$this->time = $time;
		return $this;
	
	}
	/**
	 * Generate a qCal_Time object via a string or a number of other methods
	 */
	public static function factory($time, $timezone = null) {
	
		if (is_null($timezone) || !($timezone instanceof qCal_Timezone)) {
			$timezone = qCal_Timezone::factory($timezone);
		}
		// get the default timezone so we can set it back to it later
		$tz = date_default_timezone_get();
		// set the timezone to GMT temporarily
		date_default_timezone_set("GMT");
		
		if (is_integer($time)) {
			// @todo Handle timestamps
		}
		if (is_string($time)) {
			$tstring = "01/01/1970 $time";
			if (!$timestamp = strtotime($tstring)) {
				// if unix timestamp can't be created throw an exception
				throw new qCal_DateTime_Exception_InvalidTime("Invalid or ambiguous time string passed to qCal_Time::factory()");
			}
		}
		list($hour, $minute, $second) = explode(":", gmdate("H:i:s", $timestamp));
		
		// set the timezone back to what it was
		date_default_timezone_set($tz);
		
		return new qCal_Time($hour, $minute, $second, $timezone);
	
	}
	/**
	 * Get the hour
	 */
	public function getHour() {
	
		return $this->timeArray['G'];
	
	}
	/**
	 * Get the minute
	 */
	public function getMinute() {
	
		return $this->timeArray['i'];
	
	}
	/**
	 * Get the second
	 */
	public function getSecond() {
	
		return $this->timeArray['s'];
	
	}
	/**
	 * Set the timezone
	 */
	public function setTimezone($timezone) {
	
		if (is_null($timezone) || !($timezone instanceof qCal_Timezone)) {
			$timezone = qCal_Timezone::factory($timezone);
		}
		$this->timezone = $timezone;
		return $this;
	
	}
	/**
	 * Get the timezone
	 */
	public function getTimezone() {
	
		return $this->timezone;
	
	}
	/**
	 * Get the timestamp
	 */
	public function getTimestamp($useOffset = false) {
	
		$offset = $this->getTimezone()->getOffsetSeconds();
		return ($useOffset) ?
			$this->time + $offset :
			$this->time;
	
	}
	/**
	 * Set the format to use when outputting as a string
	 */
	public function setFormat($format) {
	
		$this->format = (string) $format;
		return $this;
	
	}
	/**
	 * Output the object using PHP's date() function's meta-characters
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
			if (!$escape && array_key_exists($char, $this->timeArray)) {
				$output[] = $this->timeArray[$char];
			} else {
				$output[] = $char;
			}
			// reset this to false after every iteration that wasn't "continued"
			$escape = false;
		}
		return implode($output);
	
	}
	/**
	 * Output the object as a string
	 */
	public function __toString() {
	
		return $this->format($this->format);
	
	}

}