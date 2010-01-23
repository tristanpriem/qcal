<?php
/**
 * Because creating an array of qCal_DateTime objects is going to be way too
 * much of a memory hog for things like Minutely rules, this class allows for
 * the recurrence rules to return an iterator you can loop over to go through
 * all the dates.
 */
class qCal_DateTime_Recur_Set implements Iterator {

	protected $recur;
	
	protected $rules = array();
	
	/**
	 * Contains the current recurrence in the list of possible recurrences
	 */
	protected $current;
	
	public function __construct(qCal_DateTime_Recur $recur) {
	
		$this->recur = $recur;
	
	}
	
	/**
	 * This will overwrite any rules with the same name
	 */
	public function addRule(qCal_DateTime_Recur_Rule $rule) {
	
		$this->rules[$rule->getName()] = $rule;
	
	}
	
	public function getRule($name) {
	
		// @todo: maybe this should throw an exception if array key doesn't exist...
		return (array_key_exists($name, $this->rules)) ? $this->rules[$name] : false;
	
	}
	
	public function removeRule($name) {
	
		unset($this->rules[$name]);
		return $this;
	
	}
	
	/**
	 * Initializes all of the rules and sets $this->current to the
	 * current recurrence date/time.
	 */
	public function initRecurrences() {
	
		
	
	}
	
	public function toDateTime() {
	
		return qCal_DateTime::factory($this->current());
	
	}
	
	// @todo need to implement Iterator methods...
	
	public function current() {
	
		
	
	}
	
	public function next() {
	
		
	
	}
	
	public function key() {
	
		
	
	}
	
	public function valid() {
	
		
	
	}
	
	public function rewind() {
	
		
	
	}

}