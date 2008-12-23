<?php
/**
 * Date span object - rather than a point in time, this object represents a PERIOD of time. So, 
 * it consists of a start and end point in time
 * 
 * @package qCal
 * @subpackage qCal_Date
 * @copyright Luke Visinoni (luke.visinoni@gmail.com)
 * @author Luke Visinoni (luke.visinoni@gmail.com)
 * @license GNU Lesser General Public License
 */
class qCal_Date_Span {

	/**
	 * Start and end date/times
	 */
	protected $start, $end;
	/**
	 * Difference (in seconds) between start and end
	 */
	protected $difference;
	/**
	 * Constructor
	 */
	public function __construct($start, $end) {
	
		$this->start = new qCal_Date($start);
		$this->end = new qCal_Date($end);
		$this->difference = $this->end->time() - $this->start->time();
		if ($this->difference < 0) {
			throw new qCal_Exception_InvalidDateSpan("The start date must come before the end date.");
		}
	
	}
	/**
	 * Converts to how many seconds between the two. because this is the smallest increment
	 * used in this class, seconds are used to determine other increments, and so we store the
	 * amount of seconds instead of generating it every time
	 */
	public function seconds() {
	
		return $this->difference;
	
	}

}