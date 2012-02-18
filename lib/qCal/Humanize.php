<?php
/**
 * Humanize Helper
 * This is just a simple group of methods that help "humanize" date and time
 * information. It adds "th" or "st" to a number, converts a date to "tomorrow"
 * if it is tomorrow, etc.
 * 
 * @package     qCal
 * @subpackage  Humanize
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   Luke Visinoni <luke.visinoni@gmail.com>
 * @version     $Id$
 */
namespace qCal;
use qCal\DateTime\Date,
    qCal\DateTime\Time;

class Humanize {

    /**
     * @var array This array allows association between week day names and their
     *            integer counterparts in PHP 0 = sun and 6 = sat
     */
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
     * @var array A list of weekdays and associated numbers in accordance with
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
     * @var array An array of month names with their numbers as keys
     */
    static protected $_monthNames = array(
        1 => 'january',
        2 => 'february',
        3 => 'march',
        4 => 'april',
        5 => 'may',
        6 => 'june',
        7 => 'july',
        8 => 'august',
        9 => 'september',
        10 => 'october',
        11 => 'november',
        12 => 'december',
    );
    
    /**
     * Converts either whole or abbreviated weekday name to its associated number
     */
    static public function weekDayNameToNum($weekDayName) {
    
        if (is_int($weekDayName)) {
            // test if it's a valid number
            self::weekDayNumToName($weekDayName);
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
        // Not found, throw exception
        throw new \InvalidArgumentException(sprintf('"%s" is not a valid weekday name.', $weekDayName));
    
    }
    
    /**
     * Converts month number to its name
     */
    static public function weekDayNumToName($num, $capitalize = false) {
    
        $name = strtolower($num);
        if (array_key_exists($num, self::$_weekDays)) {
            $wdname = self::$_weekDays[$num];
            if ($capitalize) {
                $wdname = ucfirst($wdname);
            }
            return $wdname;
        } elseif (in_array($name, self::$_weekDays)) {
            // if passed a valid week name, just return it
            return $name;
        }
        throw new \InvalidArgumentException('Weekday number must be between 0 (Sunday) and 6 (Saturday).');
    
    }
    
    /**
     * Converts month name into its associated number
     */
    static public function monthNameToNum($month) {
    
        if (is_int($month)) {
            // test if it's a valid number
            self::monthNumToName($month);
            return $month;
        }
        $month = strtolower($month);
        if (in_array($month, self::$_monthNames)) {
            $monthNums = array_flip(self::$_monthNames);
            return $monthNums[$month];
        }
        // Not found, throw exception
        throw new \InvalidArgumentException(sprintf('"%s" is not a valid month name.', $month));
    
    }
    
    static public function weekDayNameToAbbr($weekday) {
    
        $weekday = strtolower($weekday);
        if (in_array($weekday, self::$_abbrWeekDays)) {
            $flipped = array_flip(self::$_abbrWeekDays);
            return $flipped[$weekday];
        }
        throw new \InvalidArgumentException(sprintf('"%s" is not a valid weekday name.', $weekday));
    
    }
    
    static public function weekDayAbbrToName($abbr) {
    
        $abbr = strtoupper($abbr);
        if (array_key_exists($abbr, self::$_abbrWeekDays)) {
            return self::$_abbrWeekDays[$abbr];
        }
        throw new \InvalidArgumentException(sprintf('"%s" is not a valid weekday abbreviation.', $abbr));
    
    }
    
    static public function weekDayAbbrToNum($abbr) {
    
        $name = self::weekDayAbbrToName($abbr);
        return self::weekDayNameToNum($name);
    
    }
    
    /**
     * Converts month number to its name
     * @todo Is Capital spelled right?
     */
    static public function monthNumToName($num, $capitalize = false) {
    
        $name = strtolower($num);
        if (array_key_exists($num, self::$_monthNames)) {
            $month = self::$_monthNames[$num];
            if ($capitalize) {
                return ucfirst($month);
            }
            return $month;
        } elseif (in_array($name, self::$_monthNames)) {
            return $name;
        }
        throw new \InvalidArgumentException('Month number must be between 1 and 12.');
    
    }
    
    /**
     * Converts 1 to 1st, 2 to 2nd, etc.
     * I got both the idea and the logic of this from django.
     * 
     * @param integer The number to convert
     * @return string The ordinal version of that number
     */
    static public function ordinal($num) {
    
        if (!is_int($num)) {
            // return it?
        }
        $suffixes = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');
        if (in_array($num % 100, array(11, 12, 13))) {
            return sprintf('%d%s', $num, $suffixes[0]);
        }
        return sprintf("%d%s", $num, $suffixes[$num % 10]);
    
    }
    
    /**
     * Get natural time
     * Converts a time object into a string such as "minutes ago", "seconds ago",
     * "seconds until", etc.
     */
    static public function naturalTime(Time $time) {
    
        
    
    }
    
    /**
     * Get natural day
     * Converts a date object into a string such as "yesterday", "tomorrow",
     * "three days ago", "ten months ago", etc.
     *
     * @param qCal\DateTime\Date The date to convert
     * @param integer The max unit of time to use (days, months, etc.)
     */
    static public function naturalDate(Date $date/*, $unit = null*/) {
    
        
    
    }

}