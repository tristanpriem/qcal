<?php
/**
 * qCal_Parser
 * The parser accepts an array of qCal_Parser_Token objects and converts them
 * to actual formatted icalendar data (in one of many formats). The default is
 * qCal_Parser_iCal which is complient with RFC 2445, but there are others as well,
 * such as qCal_Parser_xCal (xml) or qCal_Parser_hCal (microformats).
 * 
 * @package qCal
 * @subpackage qCal_Parser
 * @copyright Luke Visinoni (luke.visinoni@gmail.com)
 * @author Luke Visinoni (luke.visinoni@gmail.com)
 * @license GNU Lesser General Public License
 */ 
abstract class qCal_Parser {

    /**
     * @param array containing any options the particular parser accepts
     */
    protected $options;
    /**
     * 
     */
    public function __construct($options = array()) {
    
        $this->options = $options;
    
    }
    /**
     * Extend this method to parse raw icalendar data
     */
    abstract public function parse($data);

}