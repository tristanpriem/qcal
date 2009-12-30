<?php
class qCal_Time {

	/**
	 * Timestamp
	 */
	protected $time;
	/**
	 * Time array (contains hour, minute, second, etc.)
	 */
	protected $timeArray = array();
	/**
	 * Class constructor
	 */
	public function __construct($hour, $minute, $second, $timezone = null, $rollover = null) {
	
		$this->setTimezone($timezone);
		$this->setTime($hour, $minute, $second, $rollover);
	
	}
	/**
	 * Set the time
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
		return ($useOffset) ? $this->time + $offset : $this->time;
	
	}

}