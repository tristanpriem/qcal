<?php

/************************************************
 * How many of the following functions are we
 * planning to implement? Do we really need
 * an qCal_Import_DatabaseCustom() for inititial
 * testing?
 *
 * No we don't. That was just to show the
 * library's ability to use custom-written import
 * classes. It is just pseudo-code. - luke
 * **********************************************/
/*
// create icalendar object
$cal = new qCal(); // qCal extends qCal_Component

// create import of external calendar and import it into our calendar
$import = new qCal_Import_file($cal); // implements the qCal_Import_Interface
$import->import('../calendars/holidays.ical');
$import->import('../calendars/somethingelse.ical');

// create another importer from custom database application
$anotherimport = new qCal_Import_DatabaseCustom($cal); // custom-written import class for database crud application
$anotherimport->import();

// create a renderer to render our calendar to html hCal format
$renderer = new qCal_Renderer_hCal($cal); // implements qCal_Renderer_Interface or qCal_Renderer_Abstract
$hcal = $renderer->render('../html/calendar_display.html');

// create a renderer to render our calendar to rss
$renderer = new qCal_Renderer_rss($cal); // implements qCal_Renderer_Interface or qCal_Renderer_Abstract
$xml = $renderer->render('../rss/rss.xml');

// renders to a custom html output of our calendar
$renderer = new qCal_Renderer_HTMLCustomCalendar($cal);
$html = $renderer->render('../templates/some-template.phtml');

// create an event object
$event = new qCal_Component_Event(); // extends qCal_Component
$event->addProperty('', new qCal_Date('04/23/2007')); // internally it will accept qCal_Date and if not one, it will accept a string with date
$event->addProperty(new qCal_Event_Recur()); // this is possible (not sure of the syntax)

// attach the event object
// detach & attach accept qCal_Component objects (can be whole qCal objects)
// if event uids of $events conflict with uids from $cal, the $events overwrite
$cal->addComponent($event);

// create a todo object
$todo = new qCal_Todo(); // extends qCal_Component
$todo->setDate(new qCal_Date('04/23/2007'));
$cal->attach($todo);

// attach a new journal entry
$cal->attach(new qCal_Journal());

// create a filter to grab a range of dates (filters can grab any number / types of objects from the qCal object)
$range = new qCal_Filter_DateRange(new qCal_Date('12/25/2007'), new qCal_Date('1/1/2008')); // exnteds qCal_Filter
$event_range = $range->filter($cal); // returns an qCal object

$filter = new qCal_Filter_RemoveDuplicates($cal2);
$unique = $filter->filter($cal); // $unique is our new qCal object with no duplicates (duplicates = different uid, but same everything else)

// internally it would do $this->detachMultiple($events) or possibly just a foreach
// detach & attach accept qCal objects, any kind of qCal_Attachable object, uids (detach only), or arrays of any combination
$cal->detach($event_range);

// export event range (qCal object) to a file
$export = new qCal_Export_File($event_range);
$export->export('../calendars/christmas-newyears.ical');

$event = $event->get('1234@something');
$event->setStartDate('04/23/2007'); // internally it will accept qCal_Date and if not one, it will accept a string with date and create a qCal_Date object
$cal->attach($event); // this is how we "edit" objects, get->edit->attach()

// export calendar to a file 
$export = new qCal_Export_file($cal);
$export->export('../calendars/newcalendar.ics');

// export calendar with custom database object that implements qCal_Export_Interface or qCal_Interface_Abstract
$export = new qCal_Export_DatabaseCustom($cal); // custom-written import class for application
$export->export();
*/
set_include_path(
    //'\\\\Mc2-server\\Software Downloads\\PHP Libs' . PATH_SEPARATOR .
    //'\\\\Mc2-server\\Projects\\MC2 Design\\002967_qCal_ Library_and_App\\Web_Build\\lib' . PATH_SEPARATOR .
    'C:\\htdocs\\qCal\\lib' . PATH_SEPARATOR .
    'C:\\phplib' . PATH_SEPARATOR .
    'C:\\phplib\\qCal\\tests' . PATH_SEPARATOR .
    // add simpletest directory here
    get_include_path()
);

require_once 'Mock/qCal/Property.php';
require_once 'qCal/Property.php';
require_once 'qCal.php';

$cal = qCal::create();
$cal->addProperty(new Mock_qCal_Property());