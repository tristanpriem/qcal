<?php
/**
 * Date duration
 * 
 * @package qCal
 * @subpackage qCal_DateTime
 * @copyright Luke Visinoni (luke.visinoni@gmail.com)
 * @author Luke Visinoni (luke.visinoni@gmail.com)
 * @license GNU Lesser General Public License
 */
class qCal_DateTime_Duration {

	// This is an array of conversions from weeks, days, hours and seconds into seconds.
	// Things like months and years aren't included here because they are ambiguous. It is
	// not possible to convert a month into seconds because a month can be anywhere between
	// 28 and 31 days. Years also cannot be consistently converted into seconds.
	// IMPORTANT - don't change the order of these
	protected static $conversions = array ('W' => 604800, 'D' => 86400, 'H' => 3600, 'M' => 60, 'S' => 1);
	/**
	 * This defines all of the possible intervals of times that can be passed to the constructor
	 */
	protected $intervals = array('weeks', 'days', 'hours', 'minutes', 'seconds', 'posneg');
	/**
	 * Duration in seconds
	 */
	protected $duration;
	/**
	 * If this is negative, this will be a minus symbol. Positive doesn't need a sign, so it is just null
	 */
	protected $sign;
	/**
	 * Constructor
	 * @param array $duration An array with "weeks", "days", "hours", "minutes", and "seconds" as keys and integers as values
	 * You can also provide the "posneg" key to specify whether it is a positive or negative duration
	 */
	public function __construct(Array $duration, $rollover = true) {
	
		$this->setDuration($duration, $rollover);
	
	}
	/**
	 * Set the duration by array
	 */
	protected function setDuration($duration, $rollover) {
	
		if (!is_array($duration)) {
			// throw new qCal_DateTime_Exception_InvalidDuration("You need to provide an array with the right keys.");
			$duration = array($duration);
		}
		$intervals = array();
		foreach ($this->intervals as $intvl) {
			if (array_key_exists($intvl, $duration)) $intervals[$intvl] = $duration[$intvl];
			else $duration[$intvl] = 0;
		}
		$totalSeconds = 0;
		$posneg = "";
		foreach ($intervals as $intvl => $amnt) {
			if ($intvl == "posneg") {
				if ($amnt == "-" || $amnt == "+") $posneg = $amnt;
				continue;
			}
			$letter = strtoupper(substr($intvl, 0, 1));
			$totalSeconds += self::$conversions[$letter] * $amnt;
		}
		$this->duration = (integer) ($posneg . $totalSeconds);
		return $this;
	
	}
	/**
	 * Factory - Set duration - accepts an integer (amount of seconds) or an icalendar-formatted duration string
	 */
	public static function factory($duration) {
	
		$durationSeconds = 0;
		$posneg = "";
		// if plus or minus precedes number, remove it set in class
		if (preg_match("/^[+-]/", (string) $duration, $matches)) {
			if ($matches[0] == "-") $posneg = "-";
			$duration = str_split($duration);
			array_shift($duration);
			$duration = implode("", $duration);
		}
		if (ctype_digit($duration)) {
			$durationSeconds = $duration;
		} else {
			// convert value to duration in seconds
			preg_match('/^P([0-9]+[W])?([0-9]+[D])?T?([0-9]+[H])?([0-9]+[M])?([0-9]+[S])?$/i', $duration, $matches);
			// remove first element (which is just entire the matched string)
			array_shift($matches);
			$seconds = 0;
			foreach ($matches as $duration) {
				if (empty($duration)) continue;
				$seconds += self::calculateSeconds($duration);
			}
			$durationSeconds = $seconds;
		}
		return new qCal_DateTime_Duration(array('seconds' => $durationSeconds, 'posneg' => $posneg));
	
	}
	/**
	 * Pass in a string like "15W" or "1D" and this will return how many seconds are in it
	 */
	protected static function calculateSeconds($duration) {
	
		$duration = strtoupper($duration);
		$amnt = preg_replace("/[^0-9]/i", "", $duration);
		$inc = preg_replace("/[^A-Z]/i", "", $duration);
		return self::$conversions[$inc] * $amnt;
	
	}
	/**
	 * Converts seconds to an icalendar-formatted duration string
	 */
	public function toICal() {
	
		$total = $this->duration;
		if ($total < 0) {
			$total = abs($total);
			$return = "-P";
		} else {
			$return = "P";
		}
		// this is why order is important when defining self::$conversions
		foreach (self::$conversions as $dur => $amnt) {
			// how many "weeks" are in the value?
			$quotient = (int) ($total / $amnt);
			// get the remainder of the division
			$remainder = $total - ($quotient * $amnt);
			// now if we got a whole number as quotient, add this duration to the return string
			if ($quotient) {
				// if this is the first "time" duration, add the required T char
				if ($dur == "H" || $dur == "M" || $dur == "S") {
					if (!strpos($return, "T")) $return .= "T";
				}
				$return .= $quotient . $dur;
			}
			$total = $remainder;
		}
		return $this->sign . $return;
	
	}
	/**
	 * @todo Should this be the string representation? I dont really know.
	 */
	public function __toString() {
	
		return $this->toICal();
	
	}
	/**
	 * Get duration in seconds
	 */
	public function getSeconds() {
	
		return (integer) $this->sign . $this->duration;
	
	}

}