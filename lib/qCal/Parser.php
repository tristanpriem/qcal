<?php
/**
 * I don't even know if this is what I'll call this class. I may end up changing the interface completely.
 * It very much depends on how the other classes flush out. We'll see!
 */
abstract class qCal_Parser {

    /**
     * @param array containing any options the particular parser accepts
     */
    protected $options;
    /**
     * The constructor accepts either raw icalendar data or a file resource, so if you want to read a file, do this
     * $ical = new qCal_Parser(fopen('filename.ics', 'r'))
     * @todo This probably will not scale well, but it works for now. I may want to just provide a file handle and
     * read the file line by line instead of all at once like this.
     */
    public function __construct($options = array()) {
    
        $this->options = $options;
    
    }
    /**
     * Extend this method to parse raw icalendar data
     */
    abstract public function parse($data);

}