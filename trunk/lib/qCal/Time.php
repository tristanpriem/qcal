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
	
		/**
		 * @todo These don't account for timezone
		 */
		if (is_null($hour)) {
			$hour = date("G");
		}
		if (is_null($minute)) {
			$minute = date("i");
		}
		if (is_null($second)) {
			$second = date("s");
		}
		if (!($timezone instanceof qCal_Time_Timezone)) {
			$timezone = new qCal_Time_Timezone();
		}
		
		$this->timezone = $timezone;
		
		if (!$rollover) {
			if ($hour > 23 || $minute > 59 || $second > 59) {
				throw new qCal_Time_Exception_InvalidTime(sprintf("Invalid time specified for qCal_Time: \"%02d:%02d:%02d\"", $hour, $minute, $second));
			}
		}
		
		// now set the timestamp
		/*$time = $hour * 60 * 60;
		$time = $time + $minute * 60;
		$time = $time + $second;*/
		// by using the unix epoch date, we only end up with the amount of
		// seconds since the beginning of the day and avoid the math above :)
		// this should use gmmaketime, but it's making my head hurt, so until
		// I implement timezones, I'm using this...
		$time = gmmktime($hour, $minute, $second, 1, 1, 1970);
		$this->time = $time;
		
		// you can only use time-based metacharacters with this class, so they are defined here
		$this->timeArray['a'] = date("a", $this->time);
		$this->timeArray['A'] = date("A", $this->time);
		$this->timeArray['B'] = date("B", $this->time);
		$this->timeArray['g'] = date("g", $this->time);
		$this->timeArray['G'] = date("G", $this->time);
		$this->timeArray['h'] = date("h", $this->time);
		$this->timeArray['H'] = date("H", $this->time);
		$this->timeArray['i'] = date("i", $this->time);
		$this->timeArray['s'] = date("s", $this->time);
		$this->timeArray['u'] = date("u", $this->time); // @todo Not sure if this works as expected...
	
	}
	
	/**
	 * Because this is not associated with any certain date, it can only return a
	 * timestamp starting from the beginning of the day. This is what does that.
	 */
	public function getTimestamp() {
	
		return $this->time;
	
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