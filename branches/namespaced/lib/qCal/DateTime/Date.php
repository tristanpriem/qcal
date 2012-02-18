<?php
/**
 * qCal Date
 * This is an object representation of a date. It has no associated time or
 * timezone. It works in UTC, but actually that's irrelevant because having no
 * associated time removes it from timezones altogether.
 *
 * @package     qCal
 * @subpackage  DateTime
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   Luke Visinoni <luke.visinoni@gmail.com>
 * @version     $Id$
 */
namespace qCal\DateTime;
use qCal\Humanize;

class Date extends Base {

    /**
     * @var integer Four-digit year
     */
    protected $_year;
    
    /**
     * @var integer Month
     */
    protected $_month;
    
    /**
     * @var integer Day
     */
    protected $_day;
    
    /**
     * @var integer Weekday that week starts on
     */
    protected $_weekdayStart = 1; // defaults to Monday
    
    /**
     * @var string Default output format
     * @todo I might change this to Ymd because that is the default in iCal
     */
    protected $_format = 'Y-m-d';
    
    /**
     * @var string The PHP date format chars allowed in this class
     */
    protected $_allowedFormatLetters = 'dDjlNSwzWFmMntLoYy';
    
    /**
     * Class constructor
     *
     * @param integer Four digit year
     * @param integer Month
     * @param integer Day
     * @param boolean Set to true to allow days and months to roll over, meaning
     *                you can pass in something like 32 for $day and have it
     *                accept it as the first of the following month (depending
     *                on the month)
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
                // If any are null but not all, throw an exception. It's all or none.
                throw new \BadMethodCallException("New date expects year, month, and day. Either all must be null or none.");
            }
        } elseif (checkdate($month, $day, $year)) {
            $this->_year = $year;
            $this->_month = $month;
            $this->_day = $day;
        } else {
            throw new \InvalidArgumentException(sprintf("%04d-%02d-%02d is not a valid date.", $year, $month, $day));
        }
    
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
    
        return gmdate($letters, $this->_getTimestamp());
    
    }
    
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
     */
    public function getWeekDayName() {
    
        return $this->toString('l');
    
    }
    
    /**
     * Get the week of the year
     * This method starts the year at the first "weekday start" weekday. So if
     * that is set to Monday, the year doesn't start until the first Monday and
     * until Monday, it is week 52.
     * @access public
     * @return integer The number week the current day falls on
     */
    public function getWeekOfYear() {
    
        $woy = 0;
        $doy = 1;
        $startofyear = new Date($this->getYear(), 1, 1);
        $diy = $startofyear->getNumDaysInYear();
        $dow = $startofyear->getWeekDay();
        while ($doy <= $diy) { // loop through all days of the year
            if ($dow == $this->getWeekdayStart()) {
                $woy++;
            }
            // if $doy == the day in the loop, break then return $woy;
            if ($doy == $this->getYearDay(true)) break;
            // loop through all days of the week
            $doy++;
            if ($dow == 6) $dow = 0;
            else $dow++;
        }
        if ($woy == 0) $woy = 52;
        return $woy;
    
    }
    
    /**
     * Get how many weeks until the end of the year
     * @access public
     * @return integer The number of weeks until the end of the year
     * @see getWeekOfYear()
     */
    public function getWeeksUntilEndOfYear() {
    
        return (integer) (52 - $this->getWeekOfYear());
    
    }
    
    /**
     * Set the day each week starts on
     * @param mixed Either 0-6, SU or Sunday string
     */
    public function setWeekdayStart($start) {
    
        $this->_weekdayStart = Humanize::weekdayNameToNum($start);
        return $this;
    
    }
    
    /**
     * Get the weekday that weeks start on
     * @return integer 0 for Sunday through 6 for Saturday
     */
    public function getWeekdayStart() {
    
        return $this->_weekdayStart;
    
    }
    
    protected function _getTimestamp() {
    
        return gmmktime(0, 0, 0, $this->_month, $this->_day, $this->_year);
    
    }
    
    /**
     * Get a unix timestamp for the date
     * @return integer The amount of seconds since unix epoch (January 1, 1970 UTC)
     * @access public
     */
    public function getUnixTimestamp() {
    
        return $this->_getTimestamp();
    
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
    static public function getXthWeekdayOfMonth($xth, $weekday, $month, $year) {
    
        $negpos = substr($xth, 0, 1);
        if ($negpos == "+" || $negpos == "-") {
            $xth = (integer) substr($xth, 1);
        } else {
            $negpos = "+";
        }
        $weekday = Humanize::weekDayNameToNum($weekday);
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
        throw new \BadMethodCallException(sprintf('There is no %s %s in %s.', Humanize::ordinal($xth), Humanize::weekDayNumToName($weekday, true), $firstofmonth->getMonthName()));
    
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
    public function getXthWeekdayOfYear($xth, $weekday, $year) {
    
        $negpos = substr($xth, 0, 1);
        if ($negpos == "+" || $negpos == "-") {
            $xth = (integer) substr($xth, 1);
        } else {
            $negpos = "+";
        }
        $weekday = Humanize::weekDayNameToNum($weekday);
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
            $lastofyear = new Date($year, 12, 31);
            $day = $numdaysinyear;
            $wday = $lastofyear->getWeekDay();
            while ($day >= 1) {
                if ($weekday == $wday) {
                    $numweekdays++;
                    if ($numweekdays == $xth) {
                        $found = $day;
                        break;
                    }
                }
                if ($wday == 0) $wday = 6; // reset to Saturday after Sunday
                else $wday--;
                $day--;
            }
        }
        if ($found) {
            return new Date($year, 1, $found, true); // takes advantage of the rollover feature :)
        }
        throw new \BadMethodCallException(sprintf('There is no %s %s in %d.', Humanize::ordinal($xth), Humanize::weekDayNumToName($weekday, true), $year));
    
    }

}