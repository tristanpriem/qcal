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
     * This method will parse raw icalendar data. Eventually I might want to add a parseFromFile() method or something
     */
    public function parse($data) {
    
    	//pre($data);
    
    }

}