<?php
/**
 * Time Class
 * This is to represent a date without a time
 * Date and time classes have a lot of similar logic. They need to descend from
 * the same class or somehow consolidate their common code
 */
namespace qCal;

class Time {

    protected $_hour;
    
    protected $_minute;
    
    protected $_second;
    
    protected $_timezone;
    
    protected $_allFormatLetters = 'dDjlNSwzWFmMntLoYyaABgGhHiseIOPTZcrU';
    
    protected $_timeFormatLetters = 'AaBGgHhis';
    
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
    
    public function toString($format, $timezone = null) {
    
        // if (!is_null($format)) {
            $fs = '';
            // match all date-format characters and place a slash before any that aren't date-related
            $pattern = '/\\\?./';
            if ($ltrs = preg_match_all($pattern, $format, $matches)) {
                foreach ($matches[0] as $match) {
                    $chars = str_split($match);
                    // if character is a format char but not a time-related one, escape it
                    if (strpos($this->_allFormatLetters, $chars[0]) !== false) {
                        if (strpos($this->_timeFormatLetters, $chars[0]) === false) {
                            $match = '\\' . $match;
                        }
                    }
                    $fs .= $match;
                }
            }
        // }
        return gmdate($fs, $this->_getTimestamp($timezone));
    
    }

}