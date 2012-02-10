<?php
/**
 * qCal Date
 * Date class without an associated time. Because there is no time, there is no
 * need for a timezone. That makes this class exceedingly simple. Just set the
 * default timezone in PHP and it will work as you expect in your timezone.
 */
namespace qCal\DateTime;

class Date extends Base {

    protected $_year;
    
    protected $_month;
    
    protected $_day;
    
    protected $_format = 'Y-m-d';
    
    protected $_allowedFormatLetters = 'dDjlNSwzWFmMntLoYy';
    
    static protected $_weekDays = array(
        0 => 'sunday',
        1 => 'monday',
        2 => 'tuesday',
        3 => 'wednesday',
        4 => 'thursday',
        5 => 'friday',
        6 => 'saturday',
    );
    
    /**
     * @var Array A list of weekdays and associated numbers in accordance with
     *            the RFC. 0 = Sunday, 6 = Saturday
     */
    static protected $_abbrWeekDays = array(
        'SU' => 'sunday',
        'MO' => 'monday',
        'TU' => 'tuesday',
        'WE' => 'wednesday',
        'TH' => 'thursday',
        'FR' => 'friday',
        'SA' => 'saturday',
    );
    
    /**
     * Create new date
     * Rollover allows you to pass in something like 44 for the day and have it
     * roll over into the next month rather than throw an exception.
     */
    public function __construct($year = null, $month = null, $day = null, $rollover = false) {
    
        if ($rollover) {
            // figure out the right date after rollover
            $time = mktime(0, 0, 0, $month, $day, $year);
            $dp = getdate($time);
            $month = $dp['mon'];
            $day = $dp['mday'];
            $year = $dp['year'];
        }
        if (is_null($year) || is_null($month) || is_null($day)) {
            if (is_null($year) && is_null($month) && is_null($day)) {
                $dp = getdate();
                $this->_year = $dp['year'];
                $this->_month = $dp['mon'];
                $this->_day = $dp['mday'];
            } else {
                // If any are null but not all, throw an exception. It's all or none. @todo Shouldn't this be MissingArgumentException?
                throw new \InvalidArgumentException("New date expects year, month, and day. Either all must be null or none.");
            }
        } elseif (checkdate($month, $day, $year)) {
            $this->_year = $year;
            $this->_month = $month;
            $this->_day = $day;
        } else {
            throw new \InvalidArgumentException(sprintf("%04d-%02d-%02d is not a invalid date.", $year, $month, $day));
        }
    
    }
    
    protected function _getTimestamp() {
    
        return mktime(0, 0, 0, $this->_month, $this->_day, $this->_year);
    
    }
    
    public function fromUnixTimestamp($ts) {
    
        $dp = getdate($ts);
        return new Date($dp['year'], $dp['mon'], $dp['mday']);
    
    }
    
    public function fromString($str) {
    
        $ts = strtotime($str);
        $dp = getdate($ts);
        return new Date($dp['year'], $dp['mon'], $dp['mday']);
    
    }
    
    protected function _date($letters, $timestamp = null) {
    
        return date($letters, $this->_getTimestamp());
    
    }
    
    /**
     * Escapes letters starting with a backspace and only converts date-related
     * characters rather than PHP's full set.
    public function toString($format = null) {
    
        $fs = $this->_format;
        if (!is_null($format)) {
            $fs = '';
            // match all date-format characters and place a slash before any that aren't date-related
            $pattern = '/\\\?./';
            if ($ltrs = preg_match_all($pattern, $format, $matches)) {
                foreach ($matches[0] as $match) {
                    $chars = str_split($match);
                    // if character is a format char but not a date-related one, escape it
                    if (strpos($this->_allFormatLetters, $chars[0]) !== false) {
                        if (strpos($this->_dateFormatLetters, $chars[0]) === false) {
                            $match = '\\' . $match;
                        }
                    }
                    $fs .= $match;
                }
            }
        }
        return date($fs, $this->_getTimestamp());
    
    }
     */
    
    public function setYear($year) {
    
        $this->_year = (int) $year;
    
    }
    
    public function getYear() {
    
        return (int) $this->toString('Y');
    
    }
    
    public function setMonth($month) {
    
        $this->_month = (int) $month;
    
    }
    
    public function getMonth() {
    
        return (int) $this->toString('n');
    
    }
    
    public function setDay($day) {
    
        $this->_day = (int) $day;
    
    }
    
    public function getDay() {
    
        return (int) $this->toString('j');
    
    }
    
    public function add($add) {
    
        if (!$ts = strtotime($this->toString('Y-m-d') . " +" . $add)) {
            throw new \InvalidArgumentException('"' . $add . '" cannot be added to a date.');
        }
        $dp = getdate($ts);
        return new Date($dp['year'], $dp['mon'], $dp['mday']);
    
    }
    
    public function subtract($sub) {
    
        if (!$ts = strtotime($this->toString('Y-m-d') . " -" . $sub)) {
            throw new \InvalidArgumentException('"' . $sub . '" cannot be subtracted from a date.');
        }
        $dp = getdate($ts);
        return new Date($dp['year'], $dp['mon'], $dp['mday']);
    
    }
    
    public function isToday() {
    
        return (date('Y-m-d') == $this->toString('Y-m-d'));
    
    }
    
    public function isYesterday() {
    
        $today = new Date;
        $yesterday = $today->subtract('1 day');
        return ($yesterday->toString('Y-m-d') == $this->toString('Y-m-d'));
    
    }
    
    public function isTomorrow() {
    
        $today = new Date;
        $tomorrow = $today->add('1 day');
        return ($tomorrow->toString('Y-m-d') == $this->toString('Y-m-d'));
    
    }
    
    public function isBefore(Date $date) {
    
        return ((int) $date->toString('Ymd') > (int) $this->toString('Ymd'));
    
    }
    
    public function isAfter(Date $date) {
    
        return ((int) $date->toString('Ymd') < (int) $this->toString('Ymd'));
    
    }
    
    public function isEqualTo(Date $date) {
    
        return ((int) $date->toString('Ymd') == (int) $this->toString('Ymd'));
    
    }
    
    /**
     * A leap year occurs every four years in most cases. Because there isn't
     * EXACTLY 365.25 days in a year, there are a few simple rules for
     * determining exceptions. If a year is divisible by 100, but not by 400, it
     * is not a leap year. As of now it doesn't matter all that much because
     * the only exception in PHP's date range is 1900 and I doubt it will be
     * used much, if at all, for that year.
     */
    public function isLeapYear() {
    
        $ly = false;
        $year = $this->getYear();
        if ($year % 4 == 0) {
            if ($year % 100 == 0) {
                if ($year % 400 == 0) {
                    $ly = true;
                }
            } else {
                $ly = true;
            }
        }
        return $ly;
    
    }
    
    /**
     * Get the amount of days in the year (365 unless it is a leap-year, then it's 366)
     * @return integer The number of days in the year
     * @access public
     */
    public function getNumDaysInYear() {
    
        $num = ($this->isLeapYear()) ? 366 : 365;
        return (integer) $num;
    
    }
    
    /**
     * Get the month of this date
     * @return string The actual name of the month, capitalized
     * @access public
     */
    public function getMonthName() {
    
        return $this->toString('F');
    
    }
    
    /**
     * Get the day of the year
     * @return integer A number between 0 and 365 inclusively
     * @access public
     */
    public function getYearDay($startFromOne = false) {
    
        return (integer) $this->toString('z') + (integer) $startFromOne;
    
    }
    
    /**
     * Find how many days until the end of the year.
     * For instance, if the date is December 25th, there are 6 days until the end of the year
     * @return integer The number of days until the end of the year
     * @access public
     */
    public function getNumDaysUntilEndOfYear() {
    
        $yearday = $this->getYearDay(true);
        return (integer) ($this->getNumDaysInYear() - $yearday);
    
    }
    
    /**
     * Get how many months until the end of the year
     * @return integer The number of months until the end of the year
     * @access public
     * @todo This is really rudimentary. There is more to this, but this works for now...
     */
    public function getNumMonthsUntilEndOfYear() {
    
        return (integer) (12 - $this->getMonth());
    
    }
    
    /**
     * Return the first day of the month as a qCal_Date object
     * @return qCal\DateTime\Date The first day of the month
     * @access public
     */
    public function getFirstDayOfMonth() {
    
        return new Date($this->getYear(), $this->getMonth(), 1);
    
    }
    
    /**
     * Return the last day of the month as a qCal_Date object
     * @return qCal\DateTime\Date The last day of the month
     * @access public
     */
    public function getLastDayOfMonth() {
    
        return new Date($this->getYear(), $this->getMonth(), $this->getNumDaysInMonth());
    
    }
    
    /**
     * Get the amount of days in the current month of this year
     * @return integer The number of days in the month
     * @access public
     * @todo test this
     */
    public function getNumDaysInMonth() {
    
        return (integer) $this->toString('t');
    
    }
    
    /**
     * Get the number of days until the end of the month
     * @return integer The number of days until the end of the month
     * @access public
     */
    public function getNumDaysUntilEndOfMonth() {
    
        return (integer) ($this->getNumDaysInMonth() - $this->getDay());
    
    }
    
    /**
     * Get the day of the week 
     * @return integer A number between 0 (for Sunday) and 6 (for Saturday).
     * @access public
     */
    public function getWeekDay() {
    
        return $this->toString('w');
    
    }
    
    /**
     * Get the day of the week
     * @return string The actual name of the day of the week, capitalized
     * @access public
     * @todo test this
     */
    public function getWeekDayName() {
    
        return $this->toString('l');
    
    }
    
    /**
     * Get the week of the year
     * @return integer The week of the year (0-51 I think)
     * @access public
     * @todo Test this
     */
    public function getWeekOfYear() {
    
        return $this->toString('W');
    
    }
    
    /**
     * Get how many weeks until the end of the year
     * @access public
     * @todo This is really rudimentary. There is more to this, but this works for now...
     */
    public function getWeeksUntilEndOfYear() {
    
        return (integer) (52 - $this->getWeekOfYear());
    
    }
    
    /**
     * Get a unix timestamp for the date
     * @return integer The amount of seconds since unix epoch (January 1, 1970 UTC)
     * @access public
     */
    public function getUnixTimestamp() {
    
        
    
    }
    
    /**
     * Converts either whole or abbreviated weekday name to its associated number
     */
    static public function weekDayToNum($weekDayName) {
    
        if (is_int($weekDayName)) {
            return $weekDayName;
        }
        $upper = strtoupper($weekDayName);
        $lower = strtolower($weekDayName);
        $weekdays = array_flip(self::$_weekDays);
        if (array_key_exists($upper, self::$_abbrWeekDays)) {
            $weekday = self::$_abbrWeekDays[$upper];
            return $weekdays[$weekday];
        } elseif (array_key_exists($lower, $weekdays)) {
            return $weekdays[$lower];
        }
    
    }
    
    /**
     * Date magic
     * This class is capable of doing some really convenient things with dates.
     * It is capable of determining things such as how many days until the end of the year,
     * which monday of the month it is (ie: third monday in february), etc.
     */
    
    /**
     * Determine the number of Tuesdays (or whatever day of the week this date is) since the
     * beginning or end of the month.
     * @param integer $xth A positive or negative number that determines which weekday of the month we want
     * @param string|integer $weekday Either Sunday-Saturday or 0-6 to specify the weekday we want (can also be SU through SA)
     * @param string|integer $month Either January-December or 1-12 to specify the month we want
     * @param integer $year A valid year to specify which year we want
     * @return qCal\DateTime\Date An object representing the xth day of the month
     * @access public
     */
    static public function getXthWeekdayOfMonth($xth, $weekday = null, $month = null, $year = null) {
    
        $negpos = substr($xth, 0, 1);
        if ($negpos == "+" || $negpos == "-") {
            $xth = (integer) substr($xth, 1);
        } else {
            $negpos = "+";
        }
        $weekday = self::weekDayToNum($weekday);
        $firstofmonth = new Date($year, $month, 1);
        $numdaysinmonth = $firstofmonth->getNumDaysInMonth();
        $numweekdays = 0; // the number of weekdays that have occurred (in the loop)
        $foundday = false;
        if ($negpos == '+') {
            $day = 1;
            $wday = $firstofmonth->getWeekday();
            while ($day <= $numdaysinmonth) {
                if ($weekday == $wday) {
                    $numweekdays++;
                    if ($numweekdays == $xth) {
                        // We found the Xth weekday! 
                        $foundday = $day;
                        break;
                    }
                }
                if ($wday == 6) $wday = 0; // after Saturday reset to Sunday
                else $wday++;
                $day++;
            }
        } else {
            $day = $numdaysinmonth;
            $lastofmonth = $firstofmonth->getLastDayOfMonth();
            $wday = $lastofmonth->getWeekday();
            while ($day >= 1) {
                if ($weekday == $wday) {
                    $numweekdays++;
                    if ($numweekdays == $xth) {
                        // We found the Xth weekday!
                        $foundday = $day;
                        break;
                    }
                }
                if ($wday == 0) $wday = 6; // reset week
                else $wday--;
                $day--;
            }
        }
        if ($foundday && checkdate($month, $foundday, $year)) {
            return new Date($year, $month, $foundday);
        }
        // No day found, throw exception
    
    }
    
    /**
     * Determine the number or Tuesdays (or whatever day of the week this date is) since the
     * beginning or end of the year.
     * @param integer $xth A positive or negative number that determines which weekday of the year we want
     * @param string|integer $weekday Either Sunday-Saturday or 0-6 to specify the weekday we want (can also be SU through SA)
     * @param integer $year A valid year to specify which year we want
     * @return qCal_Date An object representing the xth day of the month
     * @access public
     */
    public function getXthWeekdayOfYear($xth, $weekday = null, $year = null) {
    
        $negpos = substr($xth, 0, 1);
        if ($negpos == "+" || $negpos == "-") {
            $xth = (integer) substr($xth, 1);
        } else {
            $negpos = "+";
        }
        $weekday = self::weekDayToNum($weekday);
        $firstofyear = new Date($year, 1, 1);
        $numdaysinyear = $firstofyear->getNumDaysInYear();
        $numweekdays = 0; // the number of weekdays that have occurred within the loop
        $found = false; // whether or not the specified day has been found
        if ($negpos == "+") {
            $day = 1;
            $wday = $firstofyear->getWeekDay();
            while ($day <= $numdaysinyear) {
                if ($weekday == $wday) {
                    $numweekdays++;
                    if ($numweekdays == $xth) {
                        // break out of the loop, we've found the right day! yay!
                        $found = $day;
                        break;
                    }
                }
                if ($wday == 6) $wday = 0; // reset to Sunday after Saturday
                else $wday++;
                $day++;
            }
        } else {
            
        }
        if ($found) {
            // $date = new qCal_Date($year, 1, $found, true); // takes advantage of the rollover feature :)
        } else {
            
        }
        return new Date();
    
    }

}