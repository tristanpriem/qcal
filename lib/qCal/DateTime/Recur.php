<?php
/**
 * Date/Time Recurrence object.
 * This class is used to define a date/time recurrence. It is capable of
 * creating recurrence rules for just about any type of recurrence. There are
 * many examples of recurrences below.
 * 
 * @package qCal
 * @subpackage qCal_DateTime_Recur
 * @copyright Luke Visinoni (luke.visinoni@gmail.com)
 * @author Luke Visinoni (luke.visinoni@gmail.com)
 * @license GNU Lesser General Public License
 */
class qCal_DateTime_Recur implements Iterator, Countable {

	/**
	 * @var array A list of valid recurrence frequencies
	 */
	protected static $validFreq = array(
		"yearly",
		"monthly",
		"weekly",
		"daily",
		"hourly",
		"minutely",
		"secondly",
	);
	
	/**
	 * @var qCal_DateTime The start date/time of this recurrence
	 */
	protected $start;
	
	/**
	 * @var array A list of qCal_DateTime_Recur_Rule objects that define this recurrence
	 */
	protected $rules = array();
	
	/**
	 * @var qCal_DateTime_Recur_Recurrence The current recurrence in the set
	 */
	protected $current;
	
	/**
	 * Class constructor
	 * This method instantiates the object by setting its "type" and its start date/time.
	 * @param mixed $start Either a qCal_DateTime or a string representing one
	 * @throws qCal_DateTime_Exception_InvalidRecurrenceType If an invalid type is specified
	 * @access public
	 */
	public function __construct($start = null, Array $rules = array()) {
	
		$this->setStart($start);
		foreach ($rules as $rule) {
			// if rule is not a supported rule type, report it
			if (!($rule instanceof qCal_DateTime_Recur_Rule)) {
				// first we need to determine what was passed in so we can complain properly
				if (is_object($rule)) {
					$ruletype = get_class($rule);
				} elseif (is_array($rule)) {
					$ruletype = "Array";
				} else {
					$ruletype = $rule;
				}
				// now throw an exception explaining why we couldn't accept the rule
				throw new qCal_DateTime_Exception_InvalidRecurrenceRule("'$ruletype' is an unsupported recurrence rule.");
			}
			$this->addRule($rule);
		}
	
	}
	
	/**
	 * Factory Class
	 * Generates a qCal_DateTime_Recur object that is specific to a certain
	 * frequency type (yearly, monthly, weekly, etc.).
	 * @param string $freq The recurrence frequency
	 * @param mixed $start Either a qCal_DateTime object or a string representing one
	 * @return qCal_DateTime_Recur A date/time recurrence object of the specified frequency
	 * @access public
	 * @static
	 */
	public static function factory($freq, $start) {
	
		$freq = strtolower($freq);
		if (!in_array($freq, self::$validFreq)) {
			throw new qCal_DateTime_Exception_InvalidRecurrenceFrequency("'$freq' is an unsupported recurrence frequency.");
		}
		$class = 'qCal_DateTime_Recur_' . ucfirst($freq);
		return new $class($start);
	
	}
	
	/**
	 * Set the date/time recurrence's start date (required)
	 * @param mixed $start Either a qCal_DateTime object or a string representing one
	 * @return $this
	 * @access public
	 */
	public function setStart($start) {
	
		if (!($start instanceof qCal_DateTime)) {
			$start = qCal_DateTime::factory($start);
		}
		$this->start = $start;
		return $this;
	
	}
	
	/**
	 * Get the date/time recurrence's start date
	 * @return qCal_DateTime
	 * @access public
	 */
	public function getStart() {
	
		return $this->start;
	
	}
	
	/**
	 * Add a qCal_DateTime_Recur_Rule object to this recurrence, changing the
	 * way it recurs. Only one of each rule type is allowed, so if there is
	 * already a rule of the type you are adding, it is overwritten.
	 * @param qCal_DateTime_Recur_Rule $rule
	 * @return $this
	 * @access public
	 */
	public function addRule(qCal_DateTime_Recur_Rule $rule) {
	
		$this->rules[get_class($rule)] = $rule;
		return $this;
	
	}
	
	/**
	 * Retrieve all recurrences from $start to $end
	 * @param mixed $start Either a qCal_DateTime object or a string representing one for the start date/time
	 * @param mixed $end Either a qCal_DateTime object or a string representing one for the end date/time
	 * @return array A list of all recurrences
	 */
	public function getRecurrenceRange($start, $end) {
	
		// I'm not sure I even want this method... I'll leave it blank for now... 
	
	}
	
	/**
	 * Begin Iterator Methods
	 */
	
	/**
	 * Current
	 * Retrieve the current recurrence in the set
	 * @return qCal_DateTime_Recur_Recurrence The current recurrence in the set
	 * @access public
	 */
	public function current() {
	
		if (!$this->current) {
			// initialize the current recurrence if there isn't one
			$this->current = new qCal_DateTime_Recur_Recurrence($this->start);
		}
		return $this->current;
	
	}
	
	/**
	 * Key
	 * Retrieve the current recurrence's key
	 * @return integer Each recurrence in the set has an associated key from 1
	 * to however many recurrences are in the set
	 * @access public
	 */
	public function key() {
	
		// return $this->current;
	
	}
	
	/**
	 * Next
	 * Move the pointer to the next recurrence in the set
	 * @return void
	 * @access public
	 */
	public function next() {
	
		// $this->current++
	
	}
	
	/**
	 * Rewind
	 * Rewind the pointer to the first recurrence in the set
	 * @return void
	 * @access public
	 */
	public function rewind() {
	
		// $this->current = 1;
	
	}
	
	/**
	 * Valid
	 * Determine if the current recurrence is within the boundry of the recurrence set.
	 * @return boolean If the current recurrence is valid, return true
	 * @access public
	 */
	public function valid() {
	
		/*
		$current = $this->current();
		if ($current instanceof qCal_DateTime_Recur_Recurrence) {
			return true;
		} else {
			return false;
		}
		*/
	
	}
	
	/**
	 * Count
	 * If there is a finite number of recurrences, that number is returned.
	 * If there is an infinite number of recurrences, -1 is returned
	 * @return integer The number of recurrences in the set
	 * @access public
	 */
	public function count() {
	
		/*
		if ($this->isInfinite()) {
			return -1;
		} else {
			$total = 0;
			foreach ($this as $val) {
				$total++;
			}
			return $total; 
		}
		*/
	
	}

}