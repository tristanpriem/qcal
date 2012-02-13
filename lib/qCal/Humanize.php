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

class Humanize {

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

}