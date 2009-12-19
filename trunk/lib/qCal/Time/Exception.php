<?php
/**
 * qCal_Time is a sub-package of qCal, so it has its own exceptions.
 */
class qCal_Time_Exception extends qCal_Exception {

	protected $time;
	public function __construct($message = null, $code = 0, Exception $previous = null, $time = null) {
	
		$this->setTime($time);
		parent::__construct($message, $code, $previous);
	
	}
	/**
	 * Any qCal_Time_Exception can optionally receive a qCal_Time object
	 */
	public function setTime($time) {
	
		$this->time = $time;
	
	}
	public function getTime() {
	
		return $this->time;
	
	}

}