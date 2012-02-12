<?php
/**
 * Abstract (base) DateTime class
 * Most of the DateTime family of classes extend this class. It gives them some
 * basic functionality such as formatting and printing. That's about it.
 *
 * @package     qCal
 * @subpackage  DateTime
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   Luke Visinoni <luke.visinoni@gmail.com>
 * @version     $Id$
 * @abstract
 */
namespace qCal\DateTime;

abstract class Base {

    /**
     * @var string A PHP date format string (default format on print overload)
     */
    protected $_format;
    
    /**
     * @var string All the PHP date format chars this family of classes supports
     */
    protected $_allFormatLetters = 'dDjlNSwzWFmMntLoYyaABgGhHiseIOPTZcrU';
    
    /**
     * @var string The PHP date format chars this particular class supports
     */
    protected $_allowedFormatLetters;
    
    /**
     * String conversion
     * This converts this class to a string for output
     *
     * @param string A PHP date format string
     * @timezone TimeZone A timezone object to output this date/time in
     * @return string A string representation of this object
     */
    public function toString($format = null, $timezone = null) {
    
        if (is_null($format)) {
            $format = $this->_format;
        }
        $ptrn = '/\\\?./';
        $converted = $format;
        if (preg_match_all($ptrn, $format, $matches)) {
            if (isset($matches[0])) {
                $letters = $matches[0];
                $converted = '';
                foreach ($letters as $letter) {
                    if (strpos($this->_allowedFormatLetters, $letter) !== false || strpos($letter, '\\') === 0) {
                        $converted .= $this->_date($letter, $timezone);
                    } else {
                        $converted .= $letter;
                    }
                }
            }
        }
        return $converted;
    
    }
    
    /**
     * Print overload method
     *
     * @return string A string representation of this object
     */
    public function __toString() {
    
        return $this->toString();
    
    }
    
    /**
     * Set the default format this object will use when printed
     *
     * @param string A PHP date format string
     * @return $this
     */
    public function setFormat($format) {
    
        $this->_format = (string) $format;
        return $this;
    
    }
    
    /**
     * Get the timestamp representation of this object
     * 
     * @return integer UNIX timestamp
     */
    protected function _getTimestamp() {
    
        return time();
    
    }
    
    /**
     * Convert a PHP date format string to its associated date/time
     *
     * @param string A PHP date format string
     * @param TimeZone The timezone to use
     * @return string Formatted date string
     */
    protected function _date($letters, $timezone = null){}

}
