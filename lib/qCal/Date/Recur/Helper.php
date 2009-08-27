<?php
abstract class qCal_Date_Recur_Helper {

	/**
	 * @var qCal_Date The start date of the recurrence
	 */
	protected $start;
	/**
	 * @var qCal_Date The current date/time this object represents
	 */
	protected $datetime;
	/**
	 * Constructor
	 * @param mixed $start The date that the recurrence starts. Accepts any
	 * thing that qCal_Date accepts in its constructor.
	 */
	public function __construct($start) {
	
		$this->start = new qCal_Date($start);
		$this->datetime = $this->start;
	
	}
	/**
	 * Return a copy of the current date/time
	 */
	public function getInstance() {
	
		$copy = new qCal_Date($this->datetime);
		return $copy;
	
	}
	/**
	 * Increment this object by however many days, weeks, or whatever the
	 * object represents.
	 * @param integer The number to increment by
	 */
	abstract public function increment($increment);
	/**
	 * Each type of helper has a different definition of "on or before" a date.
	 * For instance, for a secondly rule, "on or before 12/01/2000" would mean
	 * on or before 12:00:00, whereas for a daily rule, any time of day on
	 * 12/01/2000 would be "on or before 12/01/2000". So, it must be left up to
	 * each helper to determine the results of this method.
	 * @param mixed $date The date that we want to determine if the object is
	 * on or before. Accepts anything qCal_Date accepts.
	 */
	abstract public function onOrBefore($date);
	//abstract public function on($date);
	//abstract public function onOrAfter($date);
	//abstract public function after($date);
	//abstract public function before($date);

}