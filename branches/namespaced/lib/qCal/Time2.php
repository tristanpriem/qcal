<?php
namespace qCal;

class Time2 {

    protected $_timezone;
    
    protected $_timestamp;
    
    public function __construct($hour = null, $minute = null, $second = 0, $timezone = null) {
    
        if (is_null($timezone)) {
            $timezone = new \qCal\Timezone();
        }
        $dp = array('hours' => $hour, 'minutes' => $minute, 'seconds' => $second);
        if (is_null($hour) xor is_null($minute)) {
            // If any are null but not all, throw an exception. It's all or none.
            throw new \InvalidArgumentException("New time expects hour and minute.");
        } elseif (is_null($hour) && is_null($minute)) {
            $dp = getdate(); // needs to be adjusted for $timezone
        }
        $this->_timezone = $timezone;
        $this->_timestamp = gmmktime($dp['hours'], $dp['minutes'], $dp['seconds'], 1, 1, 1970);
    
    }
    
    public function toString($format, $tz = null) {
    
        $offset = 0;
        if ($tz instanceof TimeZone) {
            $offset = $tz->getGmtOffset();
        }
        // AAAAHHH!!! This is fucking HARD!!
        return gmdate($format, $this->_timestamp + $offset);
        
    
    }

}