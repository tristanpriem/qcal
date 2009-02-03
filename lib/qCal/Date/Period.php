<?php
/**
 * Date period object - rather than a point in time, this object represents a PERIOD of time. So, 
 * it consists of a start and end point in time
 * 
 * @package qCal
 * @subpackage qCal_Date
 * @copyright Luke Visinoni (luke.visinoni@gmail.com)
 * @author Luke Visinoni (luke.visinoni@gmail.com)
 * @license GNU Lesser General Public License
 */
class qCal_Date_Period {

	/**
	 * Start and end date/times
	 */
	protected $start, $end;
	/**
	 * Constructor
	 */
	public function __construct($start, $end) {
	
		$this->start = new qCal_Date($start);
		$this->end = new qCal_Date($end);
		if ($this->seconds() < 0) {
			throw new qCal_Date_Exception_InvalidPeriod("The start date must come before the end date.");
		}
	
	}
	/**
	 * Converts to how many seconds between the two. because this is the smallest increment
	 * used in this class, seconds are used to determine other increments
	 */
	public function seconds() {
	
		return $this->end->time() - $this->start->time();
	
	}
	/**
	 * Returns start date
	 */
	public function start() {
	
		return $this->start;
	
	}
	/**
	 * Returns end date
	 */
	public function end() {
	
		return $this->end;
	
	}

}