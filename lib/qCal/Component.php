<?php
/**
 * Base calendar component class. Events, Todos, and Calendars are
 * examples of components in qCal
 * @package qCal
 * @copyright Luke Visinoni (luke.visinoni@gmail.com)
 * @author Luke Visinoni (luke.visinoni@gmail.com)
 * @license GNU Lesser General Public License
 * 
 * RFC 2445 Definition
 * 
 * The body of the iCalendar object consists of a sequence of calendar
 * properties and one or more calendar components. The calendar
 * properties are attributes that apply to the calendar as a whole. The
 * calendar components are collections of properties that express a
 * particular calendar semantic. For example, the calendar component can
 * specify an event, a to-do, a journal entry, time zone information, or
 * free/busy time information, or an alarm.
 * 
 * The body of the iCalendar object is defined by the following
 * notation:
 * 
 *  icalbody   = calprops component
 * 
 *  calprops   = 2*(
 * 
 *             ; 'prodid' and 'version' are both REQUIRED,
 *             ; but MUST NOT occur more than once
 * 
 *             prodid /version /
 * 
 *             ; 'calscale' and 'method' are optional,
 *             ; but MUST NOT occur more than once
 * 
 *             calscale        /
 *             method          /
 * 
 *             x-prop
 * 
 *             )
 * 
 *  component  = 1*(eventc / todoc / journalc / freebusyc /
 *             / timezonec / iana-comp / x-comp)
 * 
 *  iana-comp  = "BEGIN" ":" iana-token CRLF
 * 
 *               1*contentline
 * 
 *               "END" ":" iana-token CRLF
 * 
 *  x-comp     = "BEGIN" ":" x-name CRLF
 * 
 *               1*contentline
 * 
 *               "END" ":" x-name CRLF
 * 
 * An iCalendar object MUST include the "PRODID" and "VERSION" calendar
 * properties. In addition, it MUST include at least one calendar
 * component. Special forms of iCalendar objects are possible to publish
 * just busy time (i.e., only a "VFREEBUSY" calendar component) or time
 * zone (i.e., only a "VTIMEZONE" calendar component) information. In
 * addition, a complex iCalendar object is possible that is used to
 * capture a complete snapshot of the contents of a calendar (e.g.,
 * composite of many different calendar components). More commonly, an
 * iCalendar object will consist of just a single "VEVENT", "VTODO" or
 * "VJOURNAL" calendar component.
 */
abstract class qCal_Component {

	/**
	 * The name of this component
	 * @var string
	 */
	protected $name;
	/**
	 * Contains a list of allowed parent components.
	 * @var array
	 */
	protected $allowedComponents = array();
	/**
	 * Contains an array of this component's child components (if any)
	 * @var array
	 */
	protected $children;
	/**
	 * Contains an array of this component's properties. Properties provide
	 * information about their respective components.
	 * @var array
	 */
	protected $properties;
	/**
	 * Class constructor
	 */
	public  function __construct() {}
	/**
	 * Returns the component name
	 * @return string
	 */
	public function getName() {
	
		return $this->name;
	
	}

}