<?php
/**
 * Abstract (base) DateTime class
 */
namespace qCal\DateTime;

abstract class Base {

    protected $_format;
    
    protected $_allFormatLetters = 'dDjlNSwzWFmMntLoYyaABgGhHiseIOPTZcrU';
    
    protected $_allowedFormatLetters;
    
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
    
    public function __toString() {
    
        return $this->toString();
    
    }
    
    public function setFormat($format) {
    
        $this->_format = (string) $format;
    
    }
    
    protected function _getTimestamp() {
    
        return time();
    
    }
    
    protected function _date($letters, $timezone = null){}

}

/**
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
                        if (strpos($this->_allowedFormatLetters, $chars[0]) === false) {
                            $match = '\\' . $match;
                        }
                    }
                    $fs .= $match;
                }
            }
        }
        return $this->_date($fs, $this->_getTimestamp());
*/