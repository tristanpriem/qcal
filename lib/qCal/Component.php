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
	protected $children = array();
	/**
	 * Contains an array of this component's properties. Properties provide
	 * information about their respective components. This array is associative.
	 * It uses property name as key and property object as value (or array of them
	 * if said property can be set multiple times). This is so that I can quickly
	 * look up any certain property.
	 * @var array
	 */
	protected $properties = array();
	/**
	 * Contains an array of this component's required properties
	 */
	protected $requiredProperties = array();
	/**
	 * Class constructor
	 * Accepts an array of properties, which can be simple values or actual property objects
	 * You cannot pass in child components in the constructor, you must use the "attach" method
	 * Pass in a null value to use a property's default value (some dont have defaults, so beware)
	 * Example:
	 * $cal = new qCal_Component_Calendar(array(
           'prodid' => '-// Some Property Id//',
           'someotherproperty' => null,
           qCal_Property_Version(2.0),
	   ));
	 */
	public  function __construct($properties = array()) {
	
		$addedprops = array();
		foreach ($properties as $name => $value) {
			// if value isn't a property object, generate one
			if (!($value instanceof qCal_Property)) {
				$value = qCal_Property::factory($name, $value);
			}
			$addedprops[] = $value->getName(); // getName() returns a formatted name
			$this->addProperty($value);
		}
		// if we're missing any required properties and they have no default, throw an exception
		$missing = array_diff($this->requiredProperties, $addedprops);
		foreach ($missing as $propertyname) {
			// the property factory will throw an exception if it's passed a null value for a property with no default
			try {
				$property = qCal_Property::factory($propertyname, null);
				$this->addProperty($property);
			} catch (qCal_Exception_InvalidPropertyValue $e) {
				// if that's the case, catch the exception and throw a missing property exception
				throw new qCal_Exception_MissingProperty($this->getName() . " component requires " . $propertyname . " property");
			}
		}
	
	}
	/**
	 * Returns the component name
	 * @return string
	 */
	public function getName() {
	
		return $this->name;
	
	}
	/**
	 * Returns true if this component can be attached to $component
	 * I'm sure there's a better way to do this, but this works for now
	 */
	public function canAttachTo(qCal_Component $component) {
	
		if (in_array($component->getName(), $this->allowedComponents)) return true;
	
	}
	/**
	 * Attach a component to this component (alarm inside event for example)
	 */
	public function attach(qCal_Component $component) {
	
		if (!$component->canAttachTo($this)) {
			throw new qCal_Exception_InvalidComponent($component->getName() . ' cannot be attached to ' . $this->getName());
		}
		$this->children[$component->getName()][] = $component;
	
	}
	/**
	 * The only thing I need this for so far is the parser, but it may come in handy for the facade as well
	 */
	static public function factory($name, $properties = array()) {
	
		if (empty($name)) return false;
		// capitalize
		$component = ucfirst(strtolower($name));
		$className = "qCal_Component_" . $component;
		$fileName = str_replace("_", DIRECTORY_SEPARATOR, $className) . ".php";
		qCal_Loader::loadFile($fileName);
		$class = new $className($properties);
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
	 * Returns true if this component contains a property of $name
	 *
	 * @return boolean
	 **/
	public function hasProperty($name) {
	
		$name = strtoupper($name);
		return array_key_exists($name, $this->properties);
	
	}
	
	public function getProperties() {
	
		return $this->properties;
	
	}
	
	public function getChildren() {
	
		return $this->children;
	
	}
	
	/**
	 * Renders the calendar, by default in icalendar format. If you pass
	 * in a renderer, it will use that instead
	 *
	 * @return mixed Depends on the renderer
	 */
	public function render(qCal_Renderer $renderer = null) {
	
		if (is_null($renderer)) $renderer = new qCal_Renderer_iCalendar();
		return $renderer->render($this);
	
	}
	
	/**
	 * Allows for components to get and set property values by calling
	 * qCal_Component::getPropertyName() and qCal_Component::setPropertyName('2.0') where propertyName is the property name
	 * to be set and $val is the property value.
	 * This is just a convenience facade, it isn't going to be used within the library as much as by end-users
	 */
	public function __call($method, $params) {
	
		$firstthree = substr($method, 0, 3);
		$name = substr($method, 3);
		if ($firstthree == "get") {
			// return property value
			if ($this->hasProperty($name))
				return $this->getProperty($name)->getValue();
		} elseif ($firstthree == "set") {
			$value = isset($params[0]) ? $params[0] : null;
			$params = isset($params[1]) ? $params[1] : array();
			$property = qCal_Property::factory($name, $value, $params);
			$this->addProperty($property);
		//} elseif ($firstthree == "add") {
			// add property type
		//	$property = qCal_Property::factory($name, $params);
		//	$this->addProperty($property);
			return $this;
		}
		// throw exception here?
		// throw new qCal_Exception();
	
	}

}