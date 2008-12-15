<?php
/**
 * Base component property class. version, attach, rrule are all examples
 * of component properties.
 * @package qCal
 * @copyright Luke Visinoni (luke.visinoni@gmail.com)
 * @author Luke Visinoni (luke.visinoni@gmail.com)
 * @license GNU Lesser General Public License
 * 
 * RFC 2445 Definition
 * 
 * A property is the definition of an individual attribute describing a
 * calendar or a calendar component. A property takes the form defined
 * by the "contentline" notation defined in section 4.1.1.
 * 
 * The following is an example of a property:
 * 
 *  DTSTART:19960415T133000Z
 * 
 * This memo imposes no ordering of properties within an iCalendar
 * object.
 * 
 * Property names, parameter names and enumerated parameter values are
 * case insensitive. For example, the property name "DUE" is the same as
 * "due" and "Due", DTSTART;TZID=US-Eastern:19980714T120000 is the same
 * as DtStart;TzID=US-Eastern:19980714T120000.
 */
abstract class qCal_Property {

	/**
	 * Property name (dtstart, rrule, etc)
	 * This can be auto-generated from the class name
	 * @var string
	 */
	protected $name;
	/**
	 * Property value
	 * @var qCal_Value object
	 */
	protected $value;
	/**
	 * Default value - if set to false, there is no default value
	 * @var mixed
	 */
	protected $default = false;
	/**
	 * Property Data Type (this name gets converted to class name)
	 * @var string
	 */
	protected $type;
	/**
	 * Property parameters
	 * @var array
	 */
	protected $params = array();
	/**
	 * Contains a list of components this property is allowed to be specified
	 * for
	 * @var array
	 */
	protected $allowedComponents = array();
	/**
	 * Class constructor
	 * 
	 * @todo Cast $value to whatever data type this is ($this->type)
	 */
	public  function __construct($value = null, $params = array()) {
	
		$this->name = $this->getPropertyNameFromClassName(get_class($this));
		foreach ($params as $pname => $pval) {
			$this->setParam($pname, $pval);
		}
		$this->setValue($value);
	
	}
	/**
	 * Generates a qCal_Property class based on property name, params, and value
	 * which can come directly from an icalendar file.
	 * 
	 * @todo come up with a better way to include 
	 */
	static public function factory($name, $value, $params = array()) {
	
		$className = self::getClassNameFromPropertyName($name);
		$fileName = str_replace("_", DIRECTORY_SEPARATOR, $className) . ".php";
		require_once $fileName;
		$class = new $className($value, $params);
		return $class;
	
	}
	/**
	 * Returns the property name (formatted and exactly to spec)
	 * @return string
	 */
	public function getName() {
	
		return $this->name;
	
	}
	/**
	 * Returns the property value (as a string)
	 * If you want the actual object, use getValueObject()
	 * @return string
	 */
	public function getValue() {
	
		return $this->value->__toString();
	
	}
	/**
	 * Returns raw value object
	 * @return string
	 */
	public function getValueObject() {
	
		return $this->value;
	
	}
	/**
	 * Sets the property value
	 * @param mixed
	 */
	public function setValue($value) {
	
		// if value sent is null and this property doesn't have a default value,
		// the property can't be created, so throw an invalidpropertyvalue exception
		if (is_null($value)) {
			if ($this->default === false) {
				// this is caught by factory and reported as a conformance error
				throw new qCal_Exception_InvalidPropertyValue($this->getName() . ' property must have a value');
			} else {
				$value = $this->default;
			}
		}
		// @todo Convert to this property type by doing something like $value = $this->cast($value);
		$this->value = qCal_Value::factory($this->getType(), $value);
	
	}
	/**
	 * Returns the property type
	 * @return string
	 */
	public function getType() {
	
		return $this->type;
	
	}
	/**
	 * Check if this is a property of a certain component. Some properties
	 * can only be set on certain Components. This method looks inside this
	 * property's $allowedComponents and returns true if $component is allowed
	 *
	 * @return boolean True if this is a property of $component, false otherwise
	 * @param qCal_Component The component we're evaluating
	 **/
	public function of(qCal_Component $component) {
	
		return in_array($component->getName(), $this->allowedComponents);
	
	}
	/**
	 * Determine's this property's name from the class name by adding a dash after 
	 * every capital letter and upper-casing
	 *
	 * @return string The RFC property name
	 **/
	protected function getPropertyNameFromClassName($classname) {
	
		// determine the property name by class name
		$parts = explode("_", $classname);
		end($parts);
		// find where capital letters are and insert dash
		$chars = str_split(current($parts));
		// make a copy
		$newchars = $chars;
		foreach ($chars as $pos => $char) {
			// don't add a dash for the first letter
			if (!$pos) continue;
			$num = ord($char);
			// if character is a capital letter
			if ($num >= 65 && $num <= 90) {
				// insert dash
				array_splice($newchars, $pos, 0, '-');
			}
		}
		return strtoupper(implode("", $newchars));
	
	}
	/**
	 * Determine's this property's class name from the property name
	 *
	 * @return string The property class name
	 **/
	protected function getClassNameFromPropertyName($name) {
	
		// remove dashes, capitalize properly
		$parts = explode("-", $name);
		$property = "";
		foreach ($parts as $part) $property .= trim(ucfirst(strtolower($part)));
		// get the class, and instantiate
		$className = "qCal_Property_" . $property;
		return $className;
	
	}
	/**
	 * Retreive the value of a parameter
	 *
	 * @return mixed parameter value
	 */
	public function getParam($name) {
	
		if (isset($this->params[strtoupper($name)])) {
			return $this->params[strtoupper($name)];
		}
	
	}
	/**
	 * Returns an array of all params
	 */
	public function getParams() {
	
		return $this->params;
	
	}
	/**
	 * Set the value of a parameter
	 */
	public function setParam($name, $value) {
	
		$this->params[strtoupper($name)] = $value;
	
	}
	
}