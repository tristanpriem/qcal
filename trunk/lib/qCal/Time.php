<?php
class qCal_Time {

	/**
	 * Similar to unix timestamp, but starting from the beginning of the day.
	 * This class doesn't know what the date is, so it cannot use a unix timestamp.
	 */
	protected $time;
	/**
	 * The default format that time is output as
	 */
	protected $format = "H:i:s";
	/**
	 * An array of time information (mostly from php's date function)
	 */
	protected $timeArray = array();
	/**
	 * The timezone for this class
	 */
	protected $timezone;
	/**
	 * Class constructor. Accepts hour, minute and second, and optionally a rollover boolean
	 */
	public function __construct($hour = null, $minute = null, $second = null, $timezone = null, $rollover = false) {
	
		$this->setTime($hour, $minute, $second, $timezone, $rollover);
	
	}
	/**
	 * @todo I'm not sure if time should default to zero or not... we'll see I guess...
	 */
	public function setTime($hour = null, $minute = null, $second = null, $timezone = null, $rollover = false) {
	
		if (!($timezone instanceof qCal_Timezone)) {
			$timezone = qCal_Timezone::factory($timezone);
		}
		$this->setTimezone($timezone);
		
		if (is_null($hour)) {
			$hour = date("G", $this->getTimestamp());
		}
		if (is_null($minute)) {
			$minute = date("i", $this->getTimestamp());
		}
		if (is_null($second)) {
			$second = date("s", $this->getTimestamp());
		}
		if (!$rollover) {
			if ($hour > 23 || $minute > 59 || $second > 59) {
				throw new qCal_Time_Exception_InvalidTime(sprintf("Invalid time specified for qCal_Time: \"%02d:%02d:%02d\"", $hour, $minute, $second));
			}
		}
		
		// now set the timestamp
		// by using the unix epoch date, we only end up with the amount of
		// seconds since the beginning of the day and avoid a bunch of math :)
		$time = gmmktime($hour, $minute, $second, 1, 1, 1970);
		$this->time = $time;
		
		return $this->regenerateTimeArray();
	
	}
	
	protected function regenerateTimeArray() {
	
		$formatString = "a|A|B|g|G|h|H|i|s|u";
		$keys = explode("|", $formatString);
		$vals = explode("|", gmdate($formatString, $this->getTimestamp()));
		$this->timeArray = array_merge($this->timeArray, array_combine($keys, $vals));
		return $this;
	
	}
	
	public function setTimezone($timezone) {
	
		if (!($timezone instanceof qCal_Timezone)) {
			$timezone = qCal_Timezone::factory($timezone);
		}
		$this->timezone = $timezone;
		$this->regenerateTimeArray();
		return $this;
	
	}
	
	public function getTimezone() {
	
		return $this->timezone;
	
	}
	
	/**
	 * Because this is not associated with any certain date, it can only return a
	 * timestamp starting from the beginning of the day. This is what does that.
	 */
	public function getTimestamp() {
	
		return $this->time + $this->getTimezone()->getOffsetSeconds();
	
	}
	/**
	 * Set the format that should be used when calling either __toString() or format() without an argument.
	 * @param string $format
	 */
	public function setFormat($format) {
	
		$this->format = (string) $format;
		return $this;
	
	}
	/**
	 * Format the time with php's date function's metacharacters
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
	 * Default format for time is h:m:s in 24-hour format. It can be changed by calling
	 * qCal_Time::setFormat() and using date function's metacharacters
	 */
	public function __toString() {
	
		return $this->format($this->format);
	
	}

}