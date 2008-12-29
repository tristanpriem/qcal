<?php
/**
 * Default icalendar parser (others include xcal parser, etc.)
 * @package qCal
 * @copyright Luke Visinoni (luke.visinoni@gmail.com)
 * @author Luke Visinoni (luke.visinoni@gmail.com)
 * @license GNU Lesser General Public License
 */ 
class qCal_Parser_iCalendar extends qCal_Parser {

	/**
	 * Array of components
	 */
	protected $cmpArray = array();
	/**
	 * Array of components
	 */
	protected $refQueue = array();
    /**
     * This method will parse raw icalendar data. Eventually I might want to add a parseFromFile() method or something
     */
    public function parse($data) {
    
    	$lines = explode("\r\n", $data);
    	foreach($lines as $line) {
    	    if (preg_match("/(BEGIN):([a-z]+)/i", $line, $matches)) {
    	    	// match BEGIN:COMPONENT
    	    	$this->beginComponent($matches[2]);
    	    } elseif (preg_match("/(END):([a-z]+)/i", $line, $matches)) {
    	    	// match END:COMPONENT
    	    	$this->endComponent($matches[2]);
	    	} elseif (preg_match("/([a-z0-9-]+)([;a-z0-9=]+)?:(.+)/i", $line, $matches)) {
	    		// match PROPERTYNAME;PARAM=paramvalue:PROPERTYVALUE
	    		$params = array_filter(explode(";", $matches[2]));
	    		foreach ($params as $key => $paramset) {
	    			$params = array();
	    			if (strpos($paramset, "=") !== false) {
	    				list($name, $value) = explode("=", $paramset, 2);
	    				// pretty sure this will be OK, I don't think that params can be set multiple times
	    				$params[$name] = $value;
	    			}
    			}
	    		$this->addProperty($matches[1], $matches[3], $params);
	    	} elseif (preg_match("/\s(.+)/i", $line, $matches)) {
	    		// match whitespace character and then anything (a continued content line)
	    		$this->continueProperty($matches[1]);
	    	}
    	}
    	// this isn't perfect yet, cmpArray gets filled up with every component, so we just grab the first one
    	return $this->processComponent($this->cmpArray[0]);
    
    }
    /**
     * Open a component (start it)
     */
    protected function beginComponent($name) {
    
    	$this->cmpArray[] = array(
    		'name' => $name,
    		'properties' => array(),
    		'children' => array(),
		);
		// add a reference to this component to the top of the queue
    	$this->refQueue[] =& $this->cmpArray[count($this->cmpArray)-1];
    
    }
    /**
     * End currently open component
     */
    protected function endComponent($name) {
    
    	// pop current component off ref queue
    	$component = array_pop($this->refQueue);
    	// now add child component to new current component
    	$this->refQueue[count($this->refQueue)-1]['children'][] = $component;
    
    }
    /**
     * Add a property to the currently open component
     */
    protected function addProperty($name, $value, $params) {
    
    	$this->refQueue[count($this->refQueue)-1]['properties'][] = qCal_Property::factory($name, $value, $params);
    
    }
    /**
     * Accepts a string to append to the previous property's value
     */
    protected function continueProperty($add) {
    
    	$key = count($this->refQueue[count($this->refQueue)-1]['properties'])-1;
    	$property =& $this->refQueue[count($this->refQueue)-1]['properties'][$key];
    	$property->setValue($property->getValue() . $add);
    
    }
    /**
     * Convert array from parser into a qCal component
     */
    protected function processComponent($componentArray) {
    
    	$component = qCal_Component::factory($componentArray['name'], $componentArray['properties']);
    	foreach ($componentArray['children'] as $childArray) {
    		$child = $this->processComponent($childArray);
    		$component->attach($child);
    	}
    	return $component;
    
    }

}