<?php
/**
 * Base property class
 * There are several properties defined in the icalendar specification.
 * All of those properties should extend this class
 */
class qCal_Property {

	/**
	 * @param string Property name (dtstart, rrule, etc)
	 */
	protected $name;
	/**
	 * @param mixed The value of this property
	 */
	protected $value;
	/**
	 * @param array Contains a list of components this property applies to
	 */
	protected $appliesTo = array();
	/**
	 * Class constructor
	 */
	public  function __construct() {}
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

}