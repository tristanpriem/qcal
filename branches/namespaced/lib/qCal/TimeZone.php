<?php
/**
 * qCal Timezone Class
 * TimeZone class is used throughout date and time methods to ensure correct
 * timezone is being used. ALWAYS set the default timezone on the server before
 * using anything with a timezone.
 *
 * @todo Find a way to consolidate the toString() methods of the date, time,
 * timezone, and datetime classes
 */
namespace qCal;

class TimeZone {

    protected $_tz;
    
    protected $_allFormatLetters = 'dDjlNSwzWFmMntLoYyaABgGhHiseIOPTZcrU';
    
    protected $_tzFormatLetters = 'eOPTZ';
    
    /**
     * Class Constructor
     */
    public function __construct($tz = null) {
    
        if (is_null($tz)) {
            $tz = date_default_timezone_get();
        }
        $this->set($tz);
    
    }
    
    public function set($tz) {
    
        if (!@timezone_open($tz)) {
            // @todo I'm having a really hard time getting Exception\InvalidArgumentException to work...
            throw new \InvalidArgumentException("Timezone ($tz) is not a valid timezone");
        }
        $this->_tz = $tz;
    
    }
    
    public function toString($format = 'e') {
    
        $fs = '';
        // match all date-format characters and place a slash before any that aren't date-related
        $pattern = '/\\\?./';
        if ($ltrs = preg_match_all($pattern, $format, $matches)) {
            foreach ($matches[0] as $match) {
                $chars = str_split($match);
                // if character is a format char but not a timezone-related one, escape it
                if (strpos($this->_allFormatLetters, $chars[0]) !== false) {
                    if (strpos($this->_tzFormatLetters, $chars[0]) === false) {
                        $match = '\\' . $match;
                    }
                }
                $fs .= $match;
            }
        }
        
        $formatted = '';
        $orig = @date_default_timezone_get();
        $success = @date_default_timezone_set($this->_tz);
        if ($success === true) {
            $formatted = date($fs);
        }
        date_default_timezone_set($orig);
        return $formatted;
    
    }
    
    /**
     * Get GMT offset
     */
    public function getGmtOffset() {
    
        $orig = @date_default_timezone_get();
        $success = @date_default_timezone_set($this->_tz);
        if ($success === true) {
            $dt = getdate();
            $gmt = gmmktime($dt['hours'], $dt['minutes'], $dt['seconds'], $dt['mon'], $dt['mday'], $dt['year']);
            $tz = mktime($dt['hours'], $dt['minutes'], $dt['seconds'], $dt['mon'], $dt['mday'], $dt['year']);
            $offset = $tz - $gmt;
        }
        date_default_timezone_set($orig);
        return $offset;
    
    }

}