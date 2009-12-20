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
	protected $format = "Y-m-d\TH:i:sP";
	/**
	 * Class constructor
	 * @param mixed Either a string representing the date, or a qCal_DateV2 object
	 * @param mixed Either a string representing the time, or a qCal_Time object
	 */
	public function __construct($date = null, $time = null) {
	
		if (is_null($date)) {
			// use today's date
			$date = new qCal_DateV2();
		} elseif (!($date instanceof qCal_DateV2)) {
			$date = new qCal_DateV2();
			$date->setByString($date);
		}
		if (is_null($time)) {
			// use today's time
			$time = new qCal_Time();
		}
		$this->setDate($date)
			 ->setTime($time);
	
	}
	/**
	 * Set the date portion of this object
	 * @param qCal_DateV2 An object representing the date
	 */
	public function setDate(qCal_DateV2 $date) {
	
		$this->date = $date;
		return $this;
	
	}
	/**
	 * Set the time portion of this object
	 * @param qCal_Time An object representing the time
	 */
	public function setTime(qCal_Time $time) {
	
		$this->time = $time;
		return $this;
	
	}
	/**
	 * When output as a string, you can configure how the datetime is displayed
	 * using the same meta-characters as PHP's date function. Escape meta-characters
	 * with a backslash.
	 * @param string The format of the datetime when output as a string
	 * @return $this (Fluid method)
	 */
	public function setFormat($format) {
	
		$this->format = (string) $format;
		return $this;
	
	}
	/**
	 * Format the date/time similar to php's date function
	 * @param string Any format string that works in PHP's date function works here.
	 * @return string The formatted date
	 */
	public function format($format) {
	
		$timestamp = $this->date->getUnixTimestamp() + $this->time->getTimestamp();
		return date($format, $timestamp);
	
	}
	/**
	 * The default string representation of datetime is a direct correlation to
	 * the date function's "c" metacharacter
	 * @return string The date formatted according to $this->formats
	 */
	public function __toString() {
	
		return $this->format($this->format);
	
	}

}