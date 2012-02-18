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
namespace qCal\DateTime;

class TimeZone extends Base {

    protected $_tz;
    
    protected $_format = 'e';
    
    protected $_allowedFormatLetters = 'eOPTZ';
    
    /**
     * Class Constructor
     */
    public function __construct($tz = null) {
    
        if (is_null($tz)) {
            $tz = date_default_timezone_get();
        }
        $this->set($tz);
    
    }
    
    /**
     * Finds the first timezone with this offset...
    static public function fromOffset() {
    
        $tzs = DateTimeZone::listAbbreviations();
    
    }
     */
    
    public function set($tz) {
    
        if (!@timezone_open($tz)) {
            throw new \InvalidArgumentException(sprintf('"%s" is not a valid timezone.', $tz));
        }
        $this->_tz = $tz;
    
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
    
    protected function _date($fs, $timezone = null) {
    
        $formatted = '';
        $orig = @date_default_timezone_get();
        $success = @date_default_timezone_set($this->_tz);
        if ($success === true) {
            $formatted = date($fs, $this->_getTimestamp());
        }
        date_default_timezone_set($orig);
        return $formatted;
    
    }

}