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
class qCal_Component_Calendar {

	protected $name = "VCALENDAR";
	protected $allowedParents = array();
	
}