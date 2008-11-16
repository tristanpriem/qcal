<?php
/**
 * I don't even know if this is what I'll call this class. I may end up changing the interface completely.
 * It very much depends on how the other classes flush out. We'll see!
 */
class qCal_Parser {

    
    protected $filename;
    
    public function __construct($filename) {
    
        $this->filename = $filename;
    
    }
    /**
     * Parse icalendar formatted data into an iterable object of icalendar components
     * such as events, todos, journals, etc
     * 
     * The way I'd like this to work is this. The parser loops through the file line by line. In the loop,
	 * it is determined what kind of line we're working with. If it's a BEGIN:VCOMPONENT then we need to wait until
	 * there is an END:VCOMPONENT to do anything really. So I guess what I'd have to do is loop through the inner lines
	 * creating property objects along the way. When finally the end of the component is found, all of the properties
	 * will be used to create the component. If there is a folded line, similar logic is to be used. Basically the 
	 * property wouldn't be created until the end of the long (folded) line is reached. This way the property can be
	 * created with all necessary information.
     */
    public function parse() {
    
        $lines = file($this->filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $calendar = $this->doParse($lines);
    
    }
    /**
     * This is temporary, but I'm using this method to develop the parser for now
     */
    protected function doParse($lines) {
    
    	// recursion depth
    	$depth = 0;
    	$components = array();
        foreach ($lines as $key => $line) {
        	// break apart the line at the first colon. We can be sure that there won't be a colon in the 
        	// property portion because property names can't contain a colon (even non-standard ones)
        	list($property, $value) = explode(":", $line, 2);
        	// get param name/value pairs
        	$params = explode(";", $property);
        	// property is the first value in the array
        	$property = $params[0];
        	// params are the rest of the values in the array
        	$paramsPairs = array_slice($params, 1);
        	// reset params value to blank array
        	$params = array();
        	// put params in an array
        	foreach ($paramsPairs as $param) {
        		// separate param name/value
        		list($paramname, $paramvalue) = explode("=", $param);
        		// add to params array
        		$params[$paramname] = $paramvalue;
        	}
        	switch ($property) {
        		case "BEGIN":
        			/**
        			 * The more I play with this parser, the more I am feeling there is a need for some kind
	        		 * of recursion. I need to use $lines somehow to do this. Basically, I need to eat the file
		        	 * line by line, and when I encounter a BEGIN, I simply call $this->createComponent($remaininglines)
        			 */
        			$depth++;
        			$componentName = $value;
        			$component = qCal_Component::factory($componentName);
        			echo "====================<br>starting $value, depth $depth<BR>";
        			break;
        		case "END":
        			$depth--;
        			echo "ending $value<BR>====================<br>";
        			break;
        		default:
        			$component->setProperty($property, $value);
        			echo "property $property: $value<BR>";
        	}
        }
    
    }
    /**
     * THE STUFF BELOW IS JUST IDEAS - ANY CODE ABOVE IS STUFF I ACTUALLY INTEND ON KEEPING
     */
    /**
     * Loop through every line, and generate components, properties, and params for this icalendar
     * This should actually delegate to a qCal_Parser_iCalendar class. There will also be qCal_Parser_xCalendar
     * and possible (not sure yet) qCal_Parser_vCalendar
     */
    public function ideaForParse() {
    
        // component gets set to whatever the "current" component we're inside of is
        // once we reach an "end" we set component to false again
        $component = false;
        foreach ($this->lines as $num => $line) {
        
            // line has not been processed, so set it to false
            $lineprocessed = false;
            // if there's a colon in the line, it needs to be evaluated as a property/param/component
            // if, after parsing the line into name/param, its name doesn't fall into a valid name, the line
            // is then parsed as a continuation of the previous line
            if (strpos($line, ":") !== false) {
                // grab name and value
                list($param, $value) = explode(":", $line);
                $value = rtrim($value, "\r\n");
                // switch the upper case version for consistency
                switch(strtoupper($param)) {
                    case 'BEGIN':
                        // if name is "begin" then we're starting a component. We can't create the component until we
                        // have all of its properties, so for now we just save the name of the component for later
                        $currentComponent = $value;
                        $this->reportBeginComponent($value); // this just reports that we have started a component while testing
                        // line has now been processed
                        $lineprocessed = true;
                        break;
                    case 'END':
                        // if name is "end" then we're ending a component, so set to false now
                        $currentComponent = false;
                        $this->reportEndComponent($value);
                        // now we have all of the properties necessary to create the component, so let's do it
                        // $component = qCal_Component::factory($currentComponent, $properties, $innerComponents);
                        // line has now been processed
                        $lineprocessed = true;
                        break;
                }
            } elseif (strpos($line, " ") === 0) {
                // if we're not on a line that starts with a begin, end, or property name, assume its
                // a continuation of the previous line
                echo "CONTINUATION\n";
                $this->reportLine($param, substr($line, 1), $component);
                // line is now processed
                $lineprocessed = true;
            }
            // if parser has reached this line, we're on a property, so create it
            // 
            if (!$lineprocessed) {
            	$this->reportLine($param, $value, $component);
            	// $params = $this->parseProperty($line);// @todo when reading a property with long value, this may need to be prepared to grab and add the next line as well
            	// $property = qCal_Property::factory($currentProperty, $params);
        	}
        
        }
    
    }
    
    public function reportBeginComponent($name) {
        echo "Beginning Component: $name<br>";
    }
    
    public function reportEndComponent($name) {
        echo "Ending Component: $name<br>-----------------------------------------------<br>";
    }
    
    public function reportLine($param, $value, $component = null) {
        echo "Adding param \"$param\" of value \"$value\" to $component component<br>";
    }

}