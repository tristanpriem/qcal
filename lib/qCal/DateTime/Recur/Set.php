<?php
/**
 * Because creating an array of qCal_DateTime objects is going to be way too
 * much of a memory hog for things like Minutely rules, this class allows for
 * the recurrence rules to return an iterator you can loop over to go through
 * all the dates.
 */
class qCal_DateTime_Recur_Set implements Iterator {

	/**
	 * Contains a reference to the qCal_DateTime_Recur instance that
	 * created this recurrence set.
	 */
	protected $recur;
	
	/**
	 * Contains an array of qCal_DateTime_Recur_Rule objects which determine
	 * the recurrence pattern
	 */
	protected $rules = array();
	
	/**
	 * Contains the current recurrence in the list of possible recurrences
	 */
	protected $current;
	
	/**
	 * Constructor - initializes the recurrence set
	 */
	public function __construct(qCal_DateTime_Recur $recur) {
	
		$this->recur = $recur;
	
	}
	
	/**
	 * This will overwrite any rules with the same name
	 */
	public function addRule(qCal_DateTime_Recur_Rule $rule) {
	
		$this->rules[$rule->getName()] = $rule;
	
	}
	
	/**
	 * Determine whether the set contains a rule with the specified name
	 */
	public function hasRule($name) {
	
		return (boolean) array_key_exists($name, $this->rules);
	
	}
	
	/**
	 * Returns a reference to the rule with the specified name
	 */
	public function getRule($name) {
	
		// @todo: maybe this should throw an exception if array key doesn't exist...
		return $this->hasRule($name) ? $this->rules[$name] : false;
	
	}
	
	/**
	 * Removes a rule from the set by the specified name
	 */
	public function removeRule($name) {
	
		unset($this->rules[$name]);
		return $this;
	
	}
	
	/**
	 * Initializes all of the rules and sets $this->current to the
	 * current recurrence date/time.
	 */
	public function initRecurrences() {
	
		/**
		 * What this needs to do is loop over the TYPE of recurrence it is. For instance,
		 * if it is a yearly recurrence, this needs to do a loop over a year (or if there is
		 * a larger interval, every other year or whatever), and find each item inside that
		 * year to add to the recurrences. So like if you need yearly in Jan, Feb, and Mar 
		 * on the 3rd sunday of the month at 9:00, then find those dates and then loop over
		 * the years adding them to each year.
		 */
		
		/**
		 * The really tough part is accounting for each type. How do I create the loop when
		 * I don't know ahead of time WHICH recurrence type I'm working with. That's why
		 * I think there needs to be a way to hook into each recurrence type class to determine
		 * how to loop and look for recurrence dates.
		 */
		
		$this->subset = $this->recur->getRecurrenceSubset();
		$this->current = $this->recur->getStart();
	
	}
	
	public function toDateTime() {
	
		return qCal_DateTime::factory($this->current());
	
	}
	
	/**
	 * Returns the current recurrence as a string
	 */
	public function __toString() {
	
		return $this->toDateTime()->__toString();
	
	}
	
	// @todo need to implement Iterator methods...
	
	public function current() {
	
		$this->initRecurrences();
		return $this->current;
	
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