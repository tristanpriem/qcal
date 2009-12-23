<?php
/**
 * Base date object. Stores date information only (without a time). Internally the date is stored as a
 * unix timestamp, but the time portion of it is not used. If you need a date with a time, use qCal_DateTime
 * @package qCal
 * @subpackage qCal_Date
 * @copyright Luke Visinoni (luke.visinoni@gmail.com)
 * @author Luke Visinoni (luke.visinoni@gmail.com)
 * @license GNU Lesser General Public License
 */
class qCal_DateV2 {

	/**
	 * @var unix timestamp
	 */
	protected $date;
	/**
	 * @var int The start day of the week (defaults to Monday)
	 */
	protected $wkst = 1;
	/**
	 * @var array The results of a getdate() call
	 */
	protected $dateArray = array();
	/**
	 * @var string The date format that is used when outputting via __toString() 
	 */
	protected $format = "m/d/Y";
	/**
	 * @var array This is just a mapping of weekdays to 0 (for Sunday) through 6 (for Saturday)
	 * which is a direct correlation with PHP's date function's "w" metacharacter
	 */
	protected $weekdays = array(
		"sunday",
		"monday",
		"tuesday",
		"wednesday",
		"thursday",
		"friday",
		"saturday",
	);
	/**
	 * @var array This is an array of months starting at 1 and ending on 12
	 */
	protected $months = array(
		1 =>  "january",
		2 =>  "february",
		3 =>  "march",
		4 =>  "april",
		5 =>  "may",
		6 =>  "june",
		7 =>  "july",
		8 =>  "august",
		9 =>  "september",
		10 => "october",
		11 => "november",
		12 => "december",
	);
	/**
	 * @var array The month in a two-dimensional array (picture a calendar)
	 */
	protected $monthMap = array();
	/**
	 * Class constructor
	 * @param int The year of this date
	 * @param int The month of this date
	 * @param int The day of this date
	 */
	public function __construct($year = null, $month = null, $day = null, $timezone = null, $rollover = false) {
	
		$this->setDate($year, $month, $day, $timezone, $rollover);
	
	}
	/**
	 * This is a factory method. It allows you to create a date by string or by another date object (to make a copy)
	 */
	public static function factory($date) {
	
		if (is_integer($date)) {
			// @todo Handle timestamps
		}
		if (is_string($date)) {
			if (!$timestamp = strtotime($date)) {
				// if unix timestamp can't be created throw an exception
				throw new qCal_Date_Exception_InvalidDate("Invalid or ambiguous date string passed to qCal_DateV2::factory()");
			}
		}
		
		$date = self::gmgetdate($timestamp);
		$newdate = gmmktime(0, 0, 0, $date['mon'], $date['mday'], $date['year']);
		$newdate = self::gmgetdate($newdate);
		return new qCal_DateV2($newdate['year'], $newdate['mon'], $newdate['mday']);
	
	}
	/**
	 * Set the date's timezone component
	 * @param string|qCal_Timezone Either a string which would correspond to any of PHP's
	 * built-in timezones (ie: Americal/Los_Angeles) or a qCal_Timezone component.
	 * @return qCal_DateV2 $this
	 */
	public function setTimezone($timezone) {
	
		if (!($timezone instanceof qCal_Timezone)) {
			$timezone = qCal_Timezone::factory($timezone);
		}
		$this->timezone = $timezone;
		return $this;
	
	}
	/**
	 * Get the date's timezone
	 * @return qCal_Timezone 
	 */
	public function getTimezone() {
	
		return $this->timezone;
	
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
	 * Formats the date according to either the existing $this->format, or if the $format arg is passed
	 * in, it uses that.
	 * @param string The format that is to be used (according to php's date function). Only date-related metacharacters work.
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
			if (!$escape && array_key_exists($char, $this->dateArray)) {
				$output[] = $this->dateArray[$char];
			} else {
				$output[] = $char;
			}
			// reset this to false after every iteration that wasn't "continued"
			$escape = false;
		}
		return implode($output);
	
	}
	/**
	 * Set the date of this class
	 * The date defaults to now. If any part of the date is missing, it will default to whatever "now"'s
	 * date portion is. For instance, if the year provided is 2006 and no other portion is given, it will
	 * default to today's month and day, but in the year 2006. If, for any reason the date defaults to a 
	 * nonsensical date, an exception will be thrown. For instance, if you specify the year as 2006, and
	 * the current date is february 29th, an exception will be thrown because the 29th of February does not
	 * exist in 2006. 
	 * @param int The year of this date
	 * @param int The month of this date
	 * @param int The day of this date
	 * @throws qCal_Date_Exception_InvalidDate
	 */
	public function setDate($year = null, $month = null, $day = null, $timezone = null, $rollover = false) {
	
		$now = getdate();
		if (is_null($year)) {
			$year = $now['year'];
		}
		if (is_null($month)) {
			$month = $now['mon'];
		}
		if (is_null($day)) {
			$day = $now['mday'];
		}
		if (!($timezone instanceof qCal_Timezone)) {
			$timezone = qCal_Timezone::factory($timezone);
		}
		// @todo Should this be using gmmaketime and then adjusting? Figure it out...
		$this->setTimezone($timezone);
		$this->date = gmmktime(0, 0, 0, $month, $day, $year);
		$this->dateArray = self::gmgetdate($this->date);
		if (!$rollover) {
			if ($this->dateArray["mday"] != $day || $this->dateArray["mon"] != $month || $this->dateArray["year"] != $year) {
				throw new qCal_Date_Exception_InvalidDate("Invalid date specified for qCal_DateV2: \"{$month}/{$day}/{$year}\"");
			}
		}
		
		/**
		 * When a date is instantiated, it caches information such as which weekday of the month it is.
		 * For instance, it may be the 2nd Tuesday of the month and the 3rd to last Tuesday of the month.
		 * It also does this for the year. It will be the 23rd Tuesday of the year and the 29th from last
		 * Tuesday of the year (I have no idea if that's even possible, I'm just throwing random numbers
		 * out there).
		 */
		
		// @todo Look into how much more efficient it might be to call date() only once and then break apart the result...
		$formatString = "d|D|j|l|N|S|w|z|W|F|m|M|n|t|L|o|y|Y|c|r|U";
		$keys = explode("|", $formatString);
		$vals = explode("|", gmdate($formatString, $this->date));
		$this->dateArray = array_merge($this->dateArray, array_combine($keys, $vals));
	
	}
	
	/**
	 * Getters
	 * The next dozen or so methods are just your standard getters for things such as month, day, year, week day, etc.
	 */
	
	/**
	 * Get the month (number) of this date
	 * @return integer A number between 1 and 12 inclusively
	 */
	public function getMonth() {
	
		return $this->dateArray["mon"];
	
	}
	/**
	 * Get the month of this date
	 * @return string The actual name of the month, capitalized
	 */
	public function getMonthName() {
	
		return $this->dateArray["month"];
	
	}
	/**
	 * Get the day of the month
	 * @return integer A number between 1 and 31 inclusively
	 */
	public function getDay() {
	
		return $this->dateArray["mday"];
	
	}
	/**
	 * Get the day of the year
	 * @return integer A number between 0 and 365 inclusively
	 */
	public function getYearDay() {
	
		return $this->dateArray["yday"];
	
	}
	/**
	 * Return the first day of the month as a qCal_DateV2 object
	 * @return qCal_DateV2 The first day of the month
	 */
	public function getFirstDayOfMonth() {
	
		return new qCal_DateV2($this->getYear(), $this->getMonth(), 1);
	
	}
	/**
	 * Return the last day of the month as a qCal_DateV2 object
	 * @return qCal_DateV2 The last day of the month
	 */
	public function getLastDayOfMonth() {
	
		$lastday = $this->format("t");
		return new qCal_DateV2($this->getYear(), $this->getMonth(), $lastday);
	
	}
	/**
	 * Get the year
	 * @return integer The year of this date, for example 1999
	 */
	public function getYear() {
	
		return $this->dateArray["year"];
	
	}
	/**
	 * Get the day of the week 
	 * @return integer A number between 0 (for Sunday) and 6 (for Saturday).
	 */
	public function getWeekDay() {
	
		return $this->dateArray["wday"];
	
	}
	/**
	 * Get the day of the week
	 * @return string The actual name of the day of the week, capitalized
	 */
	public function getWeekDayName() {
	
		return $this->dateArray["weekday"];
	
	}
	/**
	 * Get the amount of days in the current month of this year
	 * @return integer The number of days in the month
	 */
	public function getNumDaysInMonth() {
	
		return $this->dateArray["t"];
	
	}
	/**
	 * Get the week of the year
	 * @return integer The week of the year (0-51 I think)
	 * @todo This is not accurate if the week start isn't monday. I need to adjust for that
	 */
	public function getWeekOfYear() {
	
		return $this->dateArray["W"];
	
	}
	/**
	 * Get a unix timestamp for the date
	 * @return integer The amount of seconds since unix epoch (January 1, 1970 UTC)
	 */
	public function getUnixTimestamp() {
	
		return $this->dateArray[0];
	
	}
	
	/**
	 * Date magic
	 * This component is capable of doing some really convenient things with dates.
	 * It is capable of determining things such as how many days until the end of the year,
	 * which monday of the month it is (ie: third monday in february), etc.
	 */
	
	/**
	 * Determine the number or Tuesdays (or whatever day of the week this date is) since the
	 * beginning or end of the month.
	 * @param boolean If false, the counting starts from the beginning of the month, otherwise
	 * it starts from the end of the month.
	 */
	public function getXthWeekdayOfMonth($xth, $weekday = null, $month = null, $year = null) {
	
		$negpos = substr($xth, 0, 1);
		if ($negpos == "+" || $negpos == "-") {
			$xth = (integer) substr($xth, 1);
		} else {
			$negpos = "+";
		}
		
		if (is_null($weekday)) {
			$weekday = $this->getWeekday();
		}
		
		if (ctype_digit((string) $weekday)) {
			if (!array_key_exists($weekday, $this->weekdays)) {
				throw new qCal_Date_Exception_InvalidWeekday("\"$weekday\" is not a valid weekday.");
			}
		} else {
			$weekday = strtolower($weekday);
			if (!in_array($weekday, $this->weekdays)) {
				throw new qCal_Date_Exception_InvalidWeekday("\"$weekday\" is not a valid weekday.");
			}
			$wdays = array_flip($this->weekdays);
			$weekday = $wdays[$weekday];
		}
		
		if (is_null($month)) {
			$month = $this->getMonth();
		}
		
		if (ctype_digit((string) $month)) {
			if (!array_key_exists($month, $this->months)) {
				throw new qCal_Date_Exception_InvalidMonth("\"$month\" is not a valid month.");
			}
		} else {
			$month = strtolower($month);
			if (!in_array($month, $this->months)) {
				throw new qCal_Date_Exception_InvalidMonth("\"$month\" is not a valid month.");
			}
			$mons = array_flip($this->months);
			$month = $mons[$month];
		}
		
		if (is_null($year)) {
			$year = $this->getYear();
		}
		
		if (!ctype_digit((string) $year) || strlen($year) != 4) {
			throw new qCal_Date_Exception_InvalidYear("\"$year\" is not a valid year.");
		}
		
		// now, using the year, month and numbered weekday, we need to find the actual day of the month...
		$firstofmonth = new qCal_DateV2($year, $month, 1);
		$numdaysinmonth = $firstofmonth->getNumDaysInMonth();
		$numweekdays = 0; // the number of weekdays that have occurred (in the loop)
		$foundday = false;
		if ($negpos == "+") {
			$day = 1;
			$wday = $firstofmonth->getWeekday();
			while ($day <= $numdaysinmonth) {
				if ($weekday == $wday) {
					$numweekdays++;
					if ($numweekdays == $xth) {
						// break out of the loop, we've found the right day! yay!
						$foundday = $day;
						break;
					}
				}
				if ($wday == 6) $wday = 0; // reset to Sunday after Saturday
				else $wday++;
				$day++;
			}
		} else {
			$day = $numdaysinmonth;
			$lastofmonth = $firstofmonth->getLastDayOfMonth();

			$wday = $lastofmonth->getWeekday();
			while ($day >= 1) {
				if ($weekday == $wday) {
					$numweekdays++;
					if ($numweekdays == $xth) {
						// break out of the loop, we've found the right day! yay!
						$foundday = $day;
						break;
					}
				}
				if ($wday == 0) $wday = 6; // reset to Saturday after Sunday
				else $wday--;
				$day--;
			}
		}
		
		if ($foundday && checkdate($month, $day, $year)) {
			$date = new qCal_DateV2($year, $month, $day);
		} else {
			if ($day == 32) {
				throw new qCal_Date_Exception_InvalidDate("You have specified an incorrect number of days for qCal_Date::getXthWeekdayOfMonth()");
			} else {
				throw new qCal_Date_Exception_InvalidDate("You have entered an invalid date.");
			}
		}
		
		return $date;
	
	}
	
	/**
	 * Magic methods
	 */
	
	/**
	 * Output the date as a string. Options are as follows:
	 * @return string The formatted date
	 */
	public function __toString() {
	
		return $this->format($this->format);
	
	}
	
	/**
	 * Static methods
	 */
	
	/**
	 * Because PHP does not provide a gmgetdate() function, I borrowed this one from the
	 * comments on the getdate() function page on php.net
	 * @param integer The timestamp to use to create the date
	 */
	public static function gmgetdate($timestamp = null) {
	
		$k = array('seconds','minutes','hours','mday','wday','mon','year','yday','weekday','month',0);
		return(array_combine($k, split(":", gmdate('s:i:G:j:w:n:Y:z:l:F:U', is_null($timestamp) ? time() : $timestamp))));
	
	}

}