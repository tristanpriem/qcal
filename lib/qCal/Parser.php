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
class qCal_Parser {

    /**
     * @param array containing any options the particular parser accepts
     */
    protected $options;
    /**
     * Constructor
     * Pass in an array of options
     * @todo Come up with list of available options
     * @param array parser options
     */
    public function __construct($options = array()) {
    
        $this->options = $options;
        /**
         * Ideas for options
         *
         * searchpath - a path string to search for files in "C:\calendars;C:\Program Files\Outlook\calendars"
         */
    
    }
    /**
     * @todo What should this accept? filename? actual string content? either?
     * @todo Maybe even create a parse() for raw string and a parseFile() for a file name?
     */
    public function parse($filename, $lexer = null) {
    
        $content = file_get_contents($filename);
		if (is_null($lexer)) {
			$lexer = new qCal_Parser_Lexer_iCalendar($content);
		}
        $this->lexer = $lexer;
        return $this->doParse($this->lexer->tokenize());
    
    }
    /**
     * Override doParse in a child class if necessary
     */
	protected function doParse($tokens) {
	
		$properties = array();
		foreach ($tokens['properties'] as $propertytoken) {
			$params = array();
			foreach ($propertytoken['params'] as $paramtoken) {
				$params[$paramtoken['param']] = $paramtoken['value'];
			}
			try {
				$properties[] = qCal_Property::factory($propertytoken['property'], $propertytoken['value'], $params);
			} catch (qCal_Exception $e) {
				// @todo There should be a better way of determining what went wrong during parsing/lexing than this
				// do nothing...
				// pr($e);
			}
		}
		$component = qCal_Component::factory($tokens['component'], $properties);
		foreach ($tokens['children'] as $child) {
			$childcmpnt = $this->doParse($child);
			$component->attach($childcmpnt);
		}
		return $component;
	
	}

}