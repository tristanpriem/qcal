<?php
/**
 * Default icalendar renderer. Pass a component to the renderer, and it will render it in accordance with rfc 2445
 * @package qCal
 * @copyright Luke Visinoni (luke.visinoni@gmail.com)
 * @author Luke Visinoni (luke.visinoni@gmail.com)
 * @license GNU Lesser General Public License
 */ 
class qCal_Parser_iCalendar extends qCal_Parser {

	/**
	 * This is a queue of component data
	 */
	protected $queue = array();
	/**
	 * iCal object that gets built during parse
	protected $iCal;
	 */
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
    	    	if ($cmp = $this->endComponent($matches[2])) {
    	    		// if endComponent returns a component, then its the last one, so return it
    	    		return $cmp;
	    		}
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
    
    }
    /**
     * Open a component (start it)
     */
    protected function beginComponent($name) {
    
    	$cmpArray = array(
    		'name' => $name,
    		'properties' => array(),
	    	'children' => array(),
    	);
    	// echo "BEGINNING $name COMPONENT<BR>";
    	// add this component to the queue
    	$this->queue[] = $cmpArray;
    
    }
    /**
     * End currently open component
     */
    protected function endComponent($name) {
    
    	// echo "ENDING $name COMPONENT<BR>";
    	// make most recent component in queue an object (do array_pop) if it's name is $name, otherwise throw an exception
    	// then add this component in the children of the new most recent in queue
    	$componentArray = array_pop($this->queue);
    	$component = qCal_Component::factory($componentArray['name'], $componentArray['properties']);
    	if (isset($this->queue[count($this->queue)-1])) {
    		// if there is a parent component, add this to it
    		$this->queue[count($this->queue)-1]['children'][] = $component;
		} else {
			// otherwise, build and return the master component
			foreach ($componentArray['children'] as $property) $component->attach($property);
			return $component;
		}
    	return false;
    
    }
    /**
     * Add a property to the currently open component
     */
    protected function addProperty($name, $value, $params) {
    
    	// echo strtolower("ADDING $name PROPERTY TO CURRENT COMPONENT WITH " . implode(",", $params) . " as params<BR>");
    	// add this property to the most recent array in queue
    	$this->queue[count($this->queue)-1]['properties'][] = qCal_Property::factory($name, $value, $params);
    
    }
    /**
     * Accepts a string to append to the previous property's value
     */
    protected function continueProperty($add) {
    
    	// echo strtolower("$add<BR>");
    	// add this value to the end of the most recent item in the queue's most recent property
    	$propertykey = count($this->queue[count($this->queue)-1]['properties'])-1;
    	$value = $this->queue[count($this->queue)-1]['properties'][$propertykey]->getValue();
    	$value .= $add;
    	$this->queue[count($this->queue)-1]['properties'][$propertykey]->setValue($value);
    
    }

}