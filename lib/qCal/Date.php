<?php
class qCal_Date {

	/**
	 * Contains 4-digit year
	 */
	protected $year = null;
	/**
	 * 2-digit month
	 */
	protected $month = null;
	/**
	 * 2-digit day
	 */
	protected $day = null;
	/**
	 * 2-digit hour
	 */
	protected $hour = null;
	/**
	 * 2-digit minute
	 */
	protected $minute = null;
	/**
	 * 2-digit second
	 */
	protected $second = null;
	/**
	 * timezone
	 */
	protected $timezone = null;
	/**
	 * used in the time() method.. instead of regenerating a timestamp every time, it's stored in this var
	 */
	protected $timestamp = null;
	/**
	 * Class constructor. This method will accept any date/time format that can be parsed
	 * with the strtotime function.
	 */
	public function __construct($date = null) {
	
		$this->setValue($date);
	
	}
	/**
	 * Set date/time. This method will accept any date/time format that can be parsed
	 * with the strtotime function. Defaults to now.
	 */
	public function setValue($date = null) {
	
		if (is_null($date)) {
			$date = "now";
		}
		if (!ctype_digit($date)) $date = strtotime($date);
		$datetime = getdate($date);
		$this->year = $datetime['year'];
		$this->month = $datetime['mon'];
		$this->day = $datetime['mday'];
		$this->hour = $datetime['hours'];
		$this->minute = $datetime['minutes'];
		$this->second = $datetime['seconds'];
		$this->timezone = null;
	
	}
	/**
	 * Returns a unix timestamp
	 */
	public function time() {
	
		if (is_null($this->timestamp)) {
			$this->timestamp = mktime(
				$this->hour,
				$this->minute,
				$this->second,
				$this->month,
				$this->day,
				$this->year
			);
		}
		return $this->timestamp;
	
	}
	/**
	 * Formats the date using php's date() function
	 */
	public function format($str) {
	
		return date($str, $this->time());
	
	}

}