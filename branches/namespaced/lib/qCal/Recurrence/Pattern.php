<?php
/**
 * Date/Time Recurrence Pattern
 * This is the base/abstract class that allows the definition of date/time
 * recurrence patterns such as yearly, minutely, etc.
 */
namespace qCal\Recurrence;
use qCal\DateTime\DateTime,
    qCal\Humanize;

abstract class Pattern implements \Countable {

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
        if ($str === (string) $int) {
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
    
    /**
     * This class implements Countable and therefor must ahve this method
     * @todo Implement this for real
     */
    public function count() {
    
        return 0;
    
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
    
    public function addRule(Pattern\Rule $rule) {
    
        
    
    }

}