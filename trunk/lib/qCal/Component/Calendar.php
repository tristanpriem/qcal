<?php
/**
 * Calendar Component
 * This is the outer-most object in an icalendar file that represents
 * the calendar as a whole. All other components must be nested within
 * this component.
 * @package qCal
 * @copyright Luke Visinoni (luke.visinoni@gmail.com)
 * @author Luke Visinoni (luke.visinoni@gmail.com)
 * @license GNU Lesser General Public License
 * 
 * RFC 2445 Definition
 *
 * The Calendaring and Scheduling Core Object is a collection of
 * calendaring and scheduling information. Typically, this information
 * will consist of a single iCalendar object. However, multiple
 * iCalendar objects can be sequentially grouped together. The first
 * line and last line of the iCalendar object MUST contain a pair of
 * iCalendar object delimiter strings. The syntax for an iCalendar
 * object is as follows:
 * 
 *   icalobject = 1*("BEGIN" ":" "VCALENDAR" CRLF
 *                icalbody
 *                "END" ":" "VCALENDAR" CRLF)
 * 
 * The following is a simple example of an iCalendar object:
 * 
 *   BEGIN:VCALENDAR
 *   VERSION:2.0
 *   PRODID:-//hacksw/handcal//NONSGML v1.0//EN
 *   BEGIN:VEVENT
 *   DTSTART:19970714T170000Z
 *   DTEND:19970715T035959Z
 *   SUMMARY:Bastille Day Party
 *   END:VEVENT
 *   END:VCALENDAR
 */
class qCal_Component_Calendar extends qCal_Component {

	protected $name = "VCALENDAR";
	protected $allowedComponents = array();
	/**
	 * In order to initialize a calendar, you must specify a product id.
	 * You may also specify a version, but if you don't it will default to 2.0
	 * Properties must always have defaults. Just throw a conformance error if 
	 * a required property is not supplied.
	 */
	public function __construct($prodid = null, $version = null) {
	
		try {
			$prodidproperty = qCal_Property::factory('prodid', $prodid);
			$this->addProperty($prodidproperty);
			$versionproperty = qCal_Property::factory('version', $version);
			$this->addProperty($versionproperty);
		} catch (qCal_Exception_Property $e) {
			// this means that one of the properties could not be initiated due to invalid
			// data being passed in. Determine which property it was, and report it
			throw new qCal_Exception_Conformance($e->getProperty()->getName() . ' property must be specified for component "' . $this->getName() . '"');
		}
	
	}
	
}