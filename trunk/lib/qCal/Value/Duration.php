<?php
/**
 * Duration (of time) Value
 * This data type differs from "period" in that it does not specify start
 * and end time, just the duration (5 weeks, 1 day, etc)
 * @package qCal
 * @copyright Luke Visinoni (luke.visinoni@gmail.com)
 * @author Luke Visinoni (luke.visinoni@gmail.com)
 * @license GNU Lesser General Public License
 * 
 * Value Name: DURATION
 * 
 * Purpose: This value type is used to identify properties that contain
 * a duration of time.
 * 
 * Formal Definition: The value type is defined by the following
 * notation:
 * 
 *  dur-value  = (["+"] / "-") "P" (dur-date / dur-time / dur-week)
 * 
 *  dur-date   = dur-day [dur-time]
 *  dur-time   = "T" (dur-hour / dur-minute / dur-second)
 *  dur-week   = 1*DIGIT "W"
 *  dur-hour   = 1*DIGIT "H" [dur-minute]
 *  dur-minute = 1*DIGIT "M" [dur-second]
 *  dur-second = 1*DIGIT "S"
 *  dur-day    = 1*DIGIT "D"
 * 
 * Description: If the property permits, multiple "duration" values are
 * specified by a COMMA character (US-ASCII decimal 44) separated list
 * of values. The format is expressed as the [ISO 8601] basic format for
 * the duration of time. The format can represent durations in terms of
 * weeks, days, hours, minutes, and seconds.
 * 
 * No additional content value encoding (i.e., BACKSLASH character
 * encoding) are defined for this value type.
 * 
 * Example: A duration of 15 days, 5 hours and 20 seconds would be:
 * 
 *  P15DT5H0M20S
 * 
 * A duration of 7 weeks would be:
 * 
 *  P7W
 */
class qCal_Value_Duration extends qCal_Value {

	// an array of how manys seconds are in a minute, hour, day, etc.
	// IMPORTANT - don't change the order of these
	protected $durations = array ('W' => 604800, 'D' => 86400, 'H' => 3600, 'M' => 60, 'S' => 1);
	/**
	 * Convert seconds to duration 
	 * @todo Some type of caching? This probably doesn't need to be "calculated" every time if it hasnt changed
	 */
	public function __toString() {
	
		$total = $this->value;
		$return = "P";
		// this is why order is important when defining $this->durations
		foreach ($this->durations as $dur => $amnt) {
			// how many "weeks" are in the value?
			$quotient = (int) ($total / $amnt);
			// get the remainder of the division
			$remainder = $total - ($quotient*$amnt);
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
		return $return;
	
	}
	/**
	 * @todo: implement this
	 */
	protected function doCast($value) {
	
		// convert value to duration in seconds
		preg_match('/^[+-]?P([0-9]{1,2}[W])?([0-9]{1,2}[D])?T?([0-9]{1,2}[H])?([0-9]{1,2}[M])?([0-9]{1,2}[S])?$/i', $value, $matches);
		// remove first element (which is just entire the matched string)
		array_shift($matches);
		$seconds = 0;
		foreach ($matches as $duration) {
			if (empty($duration)) continue;
			$seconds += $this->calculateSeconds($duration);
		}
		return $seconds;
	
	}
	/**
	 * Pass in a string like "15W" or "1D" and this will return how many seconds are in it
	 */
	protected function calculateSeconds($duration) {
	
		$amnt = preg_replace("/[^0-9]/i", "", $duration);
		$inc = preg_replace("/[^A-Z]/i", "", $duration);
		return $this->durations[$inc] * $amnt;
	
	}

}