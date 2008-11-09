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
     */
    public function parse() {
    
        $this->lines = file($this->filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        // return a qCal_Iterable object... come up with a better name though
    
    }
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
                        // if name is "begin" then we're starting a component, create it, and set it as the component variable
                        $component = $value;
                        $this->beginComponent($value);
                        // line has now been processed
                        $lineprocessed = true;
                        break;
                    case 'END':
                        // if name is "end" then we're ending a component, so set to false now
                        $component = false;
                        $this->endComponent($value);
                        // line has now been processed
                        $lineprocessed = true;
                        break;
                }
            } elseif (strpos($line, " ") === 0) {
                // if we're not on a line that starts with a begin, end, or property name, assume its
                // a continuation of the previous line
                $this->parseLine($param, substr($line, 1), $component);
                // line is now processed
                $lineprocessed = true;
            }
            // if parser has reached this line, we're inside a component or we're on a 
            // property
            if (!$lineprocessed) $this->parseLine($param, $value, $component);
        
        }
    
    }
    
    public function beginComponent($name) {
        echo "Beginning Component: $name<br>";
    }
    
    public function endComponent($name) {
        echo "Ending Component: $name<br>-----------------------------------------------<br>";
    }
    
    public function parseLine($param, $value, $component = null) {
        echo "Adding param \"$param\" of value \"$value\" to $component component<br>";
    }

}