<?php
/**
 * Test qCal_Parser subpackage
 */
class UnitTestCase_Parser extends UnitTestCase {

    public function setUp() {
    
        
    
    }
    
    public function tearDown() {
    
        
    
    }
    
	public function testInitParser() {
	
		$parser = new qCal_Parser(array(
			// pass options in here
		));
		$ical = $parser->parse(TESTFILE_PATH . '/lvisinoni.ics');
		//pre($ical->render());
	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function hideOldCode() {
	
		// I hid the old test code for now, I'll add it back later
		$oldcode = <<<OLDCODE

    public function testParseRawData() {
    
    	$fn = './files/simple.ics';
    	$fh = fopen($fn, 'r');
    	$data = fread($fh, filesize($fn));
    	$parser = new qCal_Parser_iCal();
    	$ical = $parser->parse($data);
    	$this->assertIsA($ical, 'qCal_Component');
    
    }
    
    public function NOSHOWtestParser() {
    
        $parser = new qCal_Parser_iCal('./files/simple.ics');
        $calendar = $parser->parse(); // now we have an iterable collection of event, todo, etc objects in $calendar
    
    }
    
    public function NOSHOWtestGenerateCalendar() {
    
    	$calendar = qCal::factory(); // generate a calendar object
    	$calendar->attach(new qCal_Component_Event); // add an event
    	$calendar->attach(new qCal_Component_Journal); // add a journal
    	$todo = new qCal_Component_Todo(); // create a todo
    	// this is a facade
    	// what it does is call:
    	/**
	     * $summary = new qCal_Property_Summary('I eat peas');
	     * $todo->addProperty($summary);
	     * // we may also need a
	     */
    	$todo->summary('I eat peas'); // summarize todo
    	$calendar->attach($todo); // add a todo to calendar
    	$calendar->prodId('//this is cool//'); // give the calendar a product id
    	$calendar->version('2.1'); // tell calendar what version it is
    	$event = new qCal_Component_Event; // create a new event
    	$event->start('3-11-2009 9:00'); // starts on march 3 09
    	$event->end('3-11-2009 12:00'); // ends at 12 same day
    	/**
    	 * qCal_Date_Rule represents a series of dates. It is used to define event recurrence,
    	 * dates to filter by (with qCal_Filter), and probably other things in the future, and may
    	 * be useful elsewhere than this library. 
    	 * @todo compe up with a better name for it
    	 */
    	$rule = new qCal_Date_Rule(); // create a date recurrence rule
    	$rule->until(2010); // will recur until 2010
    	//$rule->count(55); // will occur 55 times
    	$rule->exclude('11-3-2009','2011'); // exclude nov 3 2009 and all of 2011
    	$rule->include('11-11-2009');
    	$rule->frequency('weekly');
    	$rule->interval('2'); // every other week
    	$rule->byDay('TU','TH'); // on tuesdays and thursdays
    	// $rule->by
    	$event->recurs($rule); // apply this rule to the recur
    
    }
    
    public function NOSHOWtestDateRecurrence() {
	
		$pattern = new DatePattern();
		$pattern->until(1995);
		// count() and until() cannot both be used
		// $pattern->count(50); // repeat pattern 50 times
		$pattern->frequency('yearly');
		$pattern->byMonth(4);
		$pattern->byMonthWeek(3);
		$pattern->byDay('tuesday');
		
		// accepts either a date (11/5/2001), a date range (1992-1993) or another DatePattern object
		// may not be possible to allow include() to include a pattern... not sure... find out.
		$pattern->except($except);
		$pattern->include($include);
	
    }
    
    public function NOSHOWtestFilterCalendar() {
    
    	$calendar = qCal::import('calendar.ics'); // imports calendar information from calendar file
    	$filter = new qCal_Filter();
    	$dates = new qCal_Date_Rule();
    	/**
    	 * I'm not sure if this will all work - I need to play around with it and see if this interface
    	 * is possible - I think it will work as long as include/exclude are evaluated separate from the recurrence type stuff below
    	 */
    	$dates->includeRange(2007, 2009); // grab dates from 2007-2009
    	$dates->include('2008', '11-23-2006'); // include all of 08 and nov 11 of 2006
    	$dates->excludeRange('9-2006','10-2006'); // exclude september to october 2006
    	$dates->exclude('4-23-2006', 'april 2007'); // exclude april 23 2006 and all of april 2007
    	/**
    	 * Recurrence rules can be used as well (hopefully)
    	 */
    	$dates->frequency('monthly'); // monthly
    	$dates->interval(2); // every other month
    	$dates->byMonthDay(2,3,5,7); // on the 2nd, 3rd, 4th, and 7th
    	$filter->add($dates);
    	/**
    	 * Can also filter by type (this is a facade that in the background would instantiate qCal_Filter_ByType
    	 * and pass the second arg to the constructor)
    	 */
    	$filter->add('ByType', array('VEVENT','VTODO','VJOURNAL'));
    	$components = $filter->filter($calendar); // returns matches
    
    }

	/**
	 * Property names, parameter names and enumerated parameter values are
	 * case insensitive. For example, the property name "DUE" is the same as
	 * "due" and "Due", DTSTART;TZID=US-Eastern:19980714T120000 is the same
	 * as DtStart;TzID=US-Eastern:19980714T120000.
	 */
	public function testPropertyNamesAndParamValuesAreCaseInsensitive() {
	
		
	
	}
OLDCODE;
	}

}