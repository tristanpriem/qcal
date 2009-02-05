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
class qCal_Parser_Token {

    /**
     * @var string token value
     */
    protected $value;
    /**
     * @var string token type
     */
    protected $type;
    /**
     * Constructor
     * @param string containing the text value
     * @param string of token type (property, component, param, text/contentline)
     */
    public function __construct($value, $type) {
    
        $this->value = $value;
        $this->type = $type;
    
    }
    /**
     * Return the token's value
     */
    public function getValue() {
    
        
    
    }

}