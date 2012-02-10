<?php
/**
 * Time Class
 * This is to represent a date without a time
 * Date and time classes have a lot of similar logic. They need to descend from
 * the same class or somehow consolidate their common code
 */
namespace qCal\DateTime;

class Time extends Base {

    protected $_hour;
    
    protected $_minute;
    
    protected $_second;
    
    protected $_timezone;
    
    protected $_format = 'H:i:s';
    
    protected $_allowedFormatLetters = 'AaBGgHhis'; // eOPTZ also?
    
    public function __construct($hour = null, $minute = null, $second = 0, $timezone = null) {
    
        $this->setHour($hour)
             ->setMinute($minute)
             ->setSecond($second)
             ->setTimezone($timezone);
    
    }
    
    protected function _getTimestamp($timezone = null) {
    
        $offset = 0;
        if (!is_null($timezone)) {
            if (!($timezone instanceof TimeZone)) {
                $timezone = new TimeZone($timezone);
            }
            $offset = $timezone->getGmtOffset() - $this->_timezone->getGmtOffset();
        }
        $ts = gmmktime($this->_hour, $this->_minute, $this->_second, 1, 1, 1970);
        return $ts - $offset;
    
    }
    
    /**
     * Get timezone for this time
     */
    public function getTimeZone() {
    
        return $this->_timezone;
    
    }
    
    public function setTimeZone($timezone = null) {
    
        if (!($timezone instanceof TimeZone)) {
            $timezone = new TimeZone($timezone);
        }
        $this->_timezone = $timezone;
        return $this;
    
    }
    
    public function getHour() {
    
        return $this->_hour;
    
    }
    
    public function setHour($hour = null) {
    
        if (is_null($hour)) {
            $dp = getdate();
            $hour = $dp['hours'];
        }
        $this->_hour = (int) $hour;
        return $this;
    
    }
    
    public function getMinute() {
    
        return $this->_minute;
    
    }
    
    public function setMinute($minute = null) {
    
        if (is_null($minute)) {
            $dp = getdate();
            $minute = $dp['minutes'];
        }
        $this->_minute = (int) $minute;
        return $this;
    
    }
    
    public function getSecond() {
    
        return $this->_second;
    
    }
    
    public function setSecond($second = null) {
    
        if (is_null($second)) {
            $dp = getdate();
            $second = $dp['seconds'];
        }
        $this->_second = (int) $second;
        return $this;
    
    }
    
    /**
     * @todo Write test for null time so u can check if this time object is
     * before now (null).
     * @todo Maybe these should just compare timestamps instead?
     */
    public function isBefore($time) {
    
        return ($this->toString('His') < $time->toString('His'));
    
    }
    
    public function isAfter($time) {
    
        return ($this->toString('His') > $time->toString('His'));
    
    }
    
    public function isEqualTo($time) {
    
        return ($this->toString('His') == $time->toString('His'));
    
    }
    
    protected function _date($fs, $timezone = null) {
    
        // @todo Nasty hack... fix it!
        // if (in_array($fs, array('e', 'O', 'P', 'T', 'Z'))) {
        //     $formatted = $this->getTimeZone()->toString($fs);
        // } else {
            $formatted = gmdate($fs, $this->_getTimestamp($timezone));
        // }
        return $formatted;
    
    }

}