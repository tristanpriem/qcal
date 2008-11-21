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
	 * Contains an array of this component's child components (if any). It uses
	 * @var array
	 */
	protected $children;
	/**
	 * Contains an array of this component's properties. Properties provide
	 * information about their respective components. This array is associative.
	 * It uses property name as key and property object as value (or array of them
	 * if said property can be set multiple times). This is so that I can quickly
	 * look up any certain property.
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
	/**
	 * Attach a component to this component (alarm inside event for example)
	 */
	public function attach($component) {
	
		$this->children[$component->getName()][] = $component;
	
	}
	/**
	 * @todo come up with a better way to include 
	 */
	static public function factory($name, $properties = array()) {
	
		// remove V
		$component = trim(ucfirst(strtolower(substr($name, 1))));
		// capitalize
		$className = "qCal_Component_" . $component;
		// generate property objects
		$propertyObjects = array();
		foreach ($properties as $property => $info) {
			$propertyObjects[] = qCal_Property::factory($property, $info['value'], $info['params']);
		}
		$fileName = str_replace("_", DIRECTORY_SEPARATOR, $className) . ".php";
		require_once $fileName;
		eval ("\$class = new " . "\$className(" . implode(', ', $propertyObjects) . ');');
		return $class;
	
	}

	/**
	 * I'm not sure how this should work. Not sure if it should be setProperty,
	 * addProperty, both? Because properties on some components can be set multiple
	 * times, while some properties have multiple values. :( I am trying to consider
	 * a case where somebody needs to open a calendar, change a few properties on a
	 * component (change event time for instance). I think the way I'll handle properties
	 * that can be set multiple times is I'll create a method do delete properties based
	 * on values, parameters, etc. since they don't really have IDs. So I tihnk I'll go
	 * with addProperty :) 
	 */
	public function addProperty(qCal_Property $property) {
	
		if (!$property->of($this)) {
			throw new qCal_Exception_InvalidProperty($this->getName() . " component does not allow " . $property->getName() . " property");
		}
		$this->properties[$property->getName()] = $property;
	
	}
	/**
	 * Returns property of this component by name
	 *
	 * @return qCal_Property
	 **/
	public function getProperty($name) {
	
		$name = strtoupper($name);
		if (array_key_exists($name, $this->properties)) return $this->properties[$name];
		return false;
	
	}
	
	/**
	 * Allows for components to set property values by calling
	 * qCal_Component::propertyName($val) where propertyName is the property name
	 * to be set and $val is the value.
	 * @throws qCal_Exception_Conformance If $method is a property that isn't
	 *         allowed for this component.
	 * @return string
	 * @todo Finish this at another time, it is not important right now. I think
	 *       this is more of a convenience than a necessity.
	 */
	public function __call($method, $params) {
	/*
		$property = qCal_Property::factory($method, $params);
		$this->addProperty($property);
	*/
	}

}