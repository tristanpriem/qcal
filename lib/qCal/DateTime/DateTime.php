<?php
/**
 * Base DateTime Class
 * Represents a fixed point in time (a certain time on a certain date in a
 * certain timezone).
 */
namespace qCal\DateTime;

class DateTime extends Base {

    protected $_date;
    
    protected $_time;
    
    protected $_format = 'c';
    
    protected $_allowedFormatLetters = 'dDjlNSwzWFmMntLoYyAaBGgHhiscreOPTZI';
    
    public function __construct($year = null, $month = null, $day = null, $hour = null, $minute = null, $second = null, $timezone = null) {
    
        if (!($timezone instanceof TimeZone)) {
            $timezone = new TimeZone();
        }
        $this->_date = new Date($year, $month, $day);
        $this->_time = new Time($hour, $minute, $second, $timezone);
    
    }
    
    protected function _getTimestamp($timezone = null) {
    
        $offset = 0;
         if ($timezone instanceof TimeZone) {
             $offset = $timezone->getGmtOffset() - $this->getTimeZone()->getGmtOffset();
        }
        $ts = gmmktime(
            $this->getTime()->getHour(),
            $this->getTime()->getMinute(),
            $this->getTime()->getSecond(),
            $this->getDate()->getMonth(),
            $this->getDate()->getDay(),
            $this->getDate()->getYear());
        return $ts - $offset;
    
    }
    
    public function getDate() {
    
        return $this->_date;
    
    }
    
    public function getTime() {
    
        return $this->_time;
    
    }
    
    public function getTimeZone() {
    
        return $this->_time->getTimeZone();
    
    }
    
    public function isDaylightSavings() {
    
        $orig = @date_default_timezone_get();
        $success = @date_default_timezone_set($this->getTimeZone()->toString());
        if ($success === true) {
            $dl = date('I', mktime(
            $this->getTime()->getHour(),
            $this->getTime()->getMinute(),
            $this->getTime()->getSecond(),
            $this->getDate()->getMonth(),
            $this->getDate()->getDay(),
            $this->getDate()->getYear()));
        }
        date_default_timezone_set($orig);
        return (boolean) $dl;
    
    }
    
    /**
     * Convert date string
     */
    protected function _date($fs, $timezone = null) {
    
        $orig = @date_default_timezone_get();
        $success = @date_default_timezone_set($this->getTimeZone()->toString());
        // @todo This is a hack to get timezone strings to work, I need to make it cleaner
        if (in_array($fs, array('e', 'O', 'P', 'T', 'Z'))) {
            $converted = $this->getTimezone()->toString($fs);
        } elseif ($fs == 'c') {
            $fs = 'Y-m-d\TH:i:s';
            $converted = gmdate($fs, $this->_getTimestamp($timezone));
            $converted .= $this->getTimeZone()->toString('P');
        } elseif($fs == 'r') {
            $fs = 'D, j M Y H:i:s ';
            $converted = gmdate($fs, $this->_getTimestamp($timezone));
            $converted .= $this->getTimeZone()->toString('O');
        } elseif ($fs == 'I') {
            $converted = $this->isDaylightSavings() ? '1' : '0';
        } else {
            $converted = gmdate($fs, $this->_getTimestamp($timezone));
        }
        date_default_timezone_set($orig);
        return $converted;
    
    }

}