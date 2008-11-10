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
	 * @param string Property name (dtstart, rrule, etc)
	 */
	protected $name;
	/**
	 * @param mixed The value of this property
	 */
	protected $value;
	/**
	 * @param mixed Data type of this property
	 */
	protected $type;
	/**
	 * @param array Contains a list of components this property can apply to
	 */
	protected $allowedComponents = array();
	/**
	 * Class constructor
	 */
	public  function __construct() {
	
		
	
	}
	/**
	 * Returns the property name
	 */
	public function getName() {
	
		return $this->name;
	
	}
	/**
	 * Returns the property value
	 */
	public function getValue() {
	
		return $this->value;
	
	}
	/**
	 * Returns the property type object
	 */
	public function getType() {
	
		return $this->type;
	
	}

}