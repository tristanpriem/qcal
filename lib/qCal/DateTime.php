<?php
/**
 * Base DateTime Class
 * Represents a fixed point in time (a certain time on a certain date in a
 * certain timezone).
 */
namespace qCal;

class DateTime {

    protected $_date;
    
    protected $_time;
    
    // protected $_timezone;
    
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
    
    /**
     * @todo Until I refactor all of the date/time/timezone classes, I'm rigging
     * this method to output its string correctly. This is NOT good design.
     */
    public function toString($format, $timezone = null) {
    
        $replacements = array(
            'e' => $this->getTimeZone()->toString('e'),
            'I' => $this->getTimeZone()->toString('I'),
            'O' => $this->getTimeZone()->toString('O'),
            'P' => $this->getTimeZone()->toString('P'),
            'T' => $this->getTimeZone()->toString('T'),
            'Z' => $this->getTimeZone()->toString('Z'),
            'c' => $this->getDate()->toString('Y-m-d') . 'T' . $this->getTime()->toString('H:i:s') . $this->getTimeZone()->toString('P'),
            'r' => $this->getDate()->toString('D, j M Y') . ' ' . $this->getTime()->toString('H:i:s') . ' ' . $this->getTimeZone()->toString('O'),
            'U' => 'U',
        );
        $dontformat = 'eIOPTZcrU';
        $chars = str_split($format);
        $fs = '';
        foreach ($chars as $char) {
            if (strpos($dontformat, $char) !== false) {
                $fs .= '\\' . $char;
            } else {
                $fs .= $char;
            }
        }
        $formatted = gmdate($fs, $this->_getTimestamp($timezone));
        $pattern = '/\\\?./';
        if ($ltrs = preg_match_all($pattern, $formatted, $matches)) {
            foreach ($matches[0] as $match) {
                if (array_key_exists($match, $replacements)) {
                    // FUCK! I can't do this, it will replace things I don't want it to replace!!
                }
            }
        }
        return $formatted;
    
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

}
// old toString()
        /*if (!($timezone instanceof TimeZone)) {
            $timezone = $this->getTimeZone();
        }
        $formatted = '';
        $format = str_split($format);
        $converters = array($this->getDate(), $this->getTime(), $timezone);
        foreach ($format as $letter) {
            foreach ($converters as $converter) {
                $converted = $converter->toString($letter);
                if ($converted != $letter) {
                    $formatted .= $converted;
                    continue 2;
                }
            }
            $formatted .= $letter;
        }
        return $formatted;*/