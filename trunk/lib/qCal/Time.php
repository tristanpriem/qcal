<?php
class qCal_Time {

	/**
	 * Similar to unix timestamp, but starting from the beginning of the day.
	 * This class doesn't know what the date is, so it cannot use a unix timestamp.
	 */
	protected $timestamp;
	/**
	 * The hour in 24-hour format
	 */
	protected $hour;
	/**
	 * The minute 0-59
	 */
	protected $minute;
	/**
	 * The second 0-59
	 */
	protected $second;
	
	public function __construct($hour = null, $minute = null, $second = null) {
	
		$this->setTime($hour, $minute, $second);
	
	}
	
	public function setTime($hour = null, $minute = null, $second = null) {
	
		if (is_null($hour)) {
			$hour = date("G");
		}
		if (is_null($minute)) {
			$minute = date("i");
		}
		if (is_null($second)) {
			$second = date("s");
		}
		$this->hour = $hour;
		$this->minute = $minute;
		$this->second = $second;
		
		// now set the timestamp
		$time = $this->hour * 60 * 60;
		$time = $time + $this->minute * 60;
		$time = $time + $this->second;
		$this->timestamp = $time;
	
	}
	
	/**
	 * Because this is not associated with any certain date, it can only return a
	 * timestamp starting from the beginning of the day. This is what does that.
	 */
	public function getTimestamp() {
	
		return $this->timestamp;
	
	}

}