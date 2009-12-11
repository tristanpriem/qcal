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
	 * Class constructor
	 * @param mixed Either a string representing the date, or a qCal_DateV2 object
	 * @param mixed Either a string representing the time, or a qCal_Time object
	 */
	public function __construct($date = null, $time = null) {
	
		if (is_null($date)) {
			// use today's date
			$date = new qCal_DateV2();
		} elseif (!($date instanceof qCal_DateV2)) {
			$
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

}