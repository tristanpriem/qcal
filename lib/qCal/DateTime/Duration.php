<?php

namespace qCal\DateTime;

class Duration {

    /**
     * @var array
     * This is an array of conversions from weeks, days, hours and seconds into
     * seconds. Things like months and years aren't included here because they
     * are ambiguous. It is not possible to convert arbitrary months into
     * seconds because a month can be anywhere between 28 and 31 days. Years
     * also cannot be consistently converted into seconds.
     * IMPORTANT - don't change the order of these
     */
    protected static $conversions = array ('W' => 604800, 'D' => 86400, 'H' => 3600, 'M' => 60, 'S' => 1);
    
    /**
     * @var array This defines all of the possible intervals of times that can
     * be passed to the constructor
     */
    protected $intervals = array('weeks', 'days', 'hours', 'minutes', 'seconds', 'posneg');
    
    /**
     * @var integer Duration in seconds
     */
    protected $duration;
    
    /**
     * @var string If this is negative, this will be a minus symbol. Positive
     * doesn't need a sign, so it will be either null or a plus symbol.
     */
    protected $sign;
    
    /**
     * Constructor
     * @param array $duration An array with "weeks", "days", "hours", "minutes",
     * and "seconds" as keys and integers as values. You can also provide the
     * "posneg" key to specify whether it is a positive or negative duration
     * @access public
     */
    public function __construct(Array $duration) {
    
        $this->setDuration($duration);
    
    }
    
    /**
     * Set the duration by array (see the constructor's comments for more info)
     * @param array $duration An array of time intervals such as "weeks", "hours", etc.
     * @param boolean $rollover Set to true to allow values to "rollover"
     * @return $this
     * @access protected
     */
    protected function setDuration($duration) {
    
        if (!is_array($duration)) {
            // throw new qCal_DateTime_Exception_InvalidDuration("You need to provide an array with the right keys.");
            $duration = array($duration);
        }
        $intervals = array();
        foreach ($this->intervals as $intvl) {
            if (array_key_exists($intvl, $duration)) $intervals[$intvl] = $duration[$intvl];
            else $duration[$intvl] = 0;
        }
        $totalSeconds = 0;
        $posneg = "";
        foreach ($intervals as $intvl => $amnt) {
            if ($intvl == "posneg") {
                if ($amnt == "-" || $amnt == "+") $posneg = $amnt;
                continue;
            }
            $letter = strtoupper(substr($intvl, 0, 1));
            $totalSeconds += self::$conversions[$letter] * $amnt;
        }
        $this->duration = (integer) ($posneg . $totalSeconds);
        return $this;
    
    }
    
    public function toString() {
    
        $total = $this->duration;
        if ($total < 0) {
            $total = abs($total);
            $return = "-P";
        } else {
            $return = "P";
        }
        // this is why order is important when defining self::$conversions
        foreach (self::$conversions as $dur => $amnt) {
            // how many "weeks" are in the value?
            $quotient = (int) ($total / $amnt);
            // get the remainder of the division
            $remainder = $total - ($quotient * $amnt);
            // now if we got a whole number as quotient, add this duration to the return string
            if ($quotient) {
                // if this is the first "time" duration, add the required T char
                if ($dur == "H" || $dur == "M" || $dur == "S") {
                    if (!strpos($return, "T")) $return .= "T";
                }
                $return .= $quotient . $dur;
            }
            $total = $remainder;
        }
        return $this->sign . $return;
    
    }
    
    /**
     * Get duration in seconds
     * @return integer The amount of seconds that this duration represents
     * @access public
     */
    public function getSeconds() {
    
        $seconds = $this->duration;
        if ($this->sign == '-') $seconds = $this->sign . $seconds;
        return (integer) $seconds;
    
    }

}