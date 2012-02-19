<?php
/**
 * Date/Time Recurrence Pattern
 * This is the base/abstract class that allows the definition of date/time
 * recurrence patterns such as yearly, minutely, etc.
 */
namespace qCal\Recurrence;
use qCal\DateTime\DateTime,
    qCal\Humanize;

abstract class Pattern implements \Countable, \SeekableIterator {

    /**
     * @var DateTime Optional start date/time
     */
    protected $_start;
    
    /**
     * @var DateTime Optional end date/time
     *      (until and count are mutually exclusive)
     */
    protected $_until;
    
    /**
     * @var integer The optional number of times to repeat this pattern
     *              (until and count are mutually exclusive)
     */
    protected $_count;
    
    /**
     * @var integer The day that weeks start on (0 = Sunday and 6 = Saturday)
     */
    protected $_wkst = 1;
    
    /**
     * @var integer The interval for the pattern
     */
    protected $_interval = 1;
    
    /**
     * @var array A list of rules applied to this recurrence pattern
     */
    protected $_rules = array();
    
    /**
     * @var integer Represents this object's internal pointer to the current iteration
     */
    protected $_position = 0;
    
    /**
     * According to the RFC, rule parts are to be evaluated in this order. There
     * is an example of how this order is used in the tests for this class.
     */
    protected $_ruleOrder = array('ByMonth', 'ByWeekNo', 'ByYearDay', 'ByMonthDay', 'ByDay', 'ByHour', 'ByMinute', 'BySecond', 'BySetPos');
    
    /**
     * Class constructor
     *
     * @param integer The interval of time to repeat the pattern
     */
    public function __construct($interval = null) {
    
        $this->setInterval($interval);
    
    }
    
    /**
     * Set the interval
     */
    public function setInterval($interval) {
    
        if (is_null($interval)) return $this;
        $int = (integer) $interval;
        $str = (string) $interval;
        // if interval is an integer (or a string representing an integer)
        if ($str === (string) $int) {
            // if interval is positive
            if (abs($int) === $int) {
                $this->_interval = $int;
                return $this;
            }
        }
        throw new \InvalidArgumentException(sprintf('"%s" is not a valid interval.', $interval));
    
    }
    
    public function getInterval() {
    
        return $this->_interval;
    
    }
    
    public function setStart(DateTime $datetime) {
    
        $this->_start = $datetime;
        return $this;
    
    }
    
    public function getStart() {
    
        return $this->_start;
    
    }
    
    /**
     * Sets the date/time to end the recurrence pattern. The "UNTIL" and "COUNT"
     * rule parts are mutually exclusive so when you set one it "unsets" the other.
     */
    public function setUntil(DateTime $datetime) {
    
        $this->_count = null;
        $this->_until = $datetime;
        return $this;
    
    }
    
    public function getUntil() {
    
        return $this->_until;
    
    }
    
    public function setCount($count) {
    
        $this->_until = null;
        $this->_count = (integer) $count;
        return $this;
    
    }
    
    public function getCount() {
    
        return $this->_count;
    
    }
    
    public function setWeekStart($wkst) {
    
        if (strlen($wkst) == 2) {
            $wkst = Humanize::weekdayAbbrToNum($wkst);
        }
        $this->_wkst = Humanize::weekDayNameToNum($wkst);
        return $this;
    
    }
    
    public function getWeekStart() {
    
        return $this->_wkst;
    
    }
    
    /**
     * @todo Find out whether it is allowable to have multiple rules of the same type or not
     */
    public function addRule(Pattern\Rule $rule) {
    
        $this->_rules[get_class($rule)] = $rule;
        return $this;
    
    }
    
    public function getRules() {
    
        return $this->_rules;
    
    }
    
    public function hasRule($rule) {
    
        $srch = array_shift(array_reverse(explode('\\', $rule)));
        $rules = array_keys($this->_rules);
        foreach ($rules as $rl) {
            $find = array_shift(array_reverse(explode('\\', $rl)));
            if ($srch == $find) return true;
        }
        return false;
    
    }
    
    public function getRule($rule) {
    
        $srch = array_shift(array_reverse(explode('\\', $rule)));
        foreach ($this->_rules as $key => $rl) {
            $find = array_shift(array_reverse(explode('\\', $key)));
            if ($srch == $find) return $rl;
        }
        throw new \BadMethodCallException(sprintf('This pattern does not contain a "%s" rule.', $rule));
    
    }
    
    /**
     * @todo This should print the recurrence rule in iCalendar format
     */
    public function __toString() {
    
        
    
    }
    
    /**
     * This class implements Countable and therefor must ahve this method
     * @todo Implement this for real
     * @todo If this pattern goes on infinitely in either direction, return -1
     */
    public function count() {
    
        return 0;
    
    }
    
    public function seek($position) {
    
        
    
    }
    
    /**
     * Rewind the iterator to the beginning and initialize it
     */
    public function rewind() {
    
        
    
    }
    
    public function current() {
    
        
    
    }
    
    /**
     * Advance the internal pointer to the next recurrence
     * @note delegates to each individual pattern type
     * @return void
     */
    public function next() {
    
        
    
    }
    
    public function key() {
    
        
    
    }
    
    public function valid() {
    
        
    
    }
    
    /**
     * @todo Return recurrences from DTSTART to UNTIL/COUNT or $start to $end
     * Throw exception if recurrences are infinite and there is no $start and $end
     */
    /*abstract*/ public function getRecurrences() {}

}