<?php
/**
 * Base component class
 * There are several components defined in the icalendar specification.
 * All of those components should extend this class (including the 
 * iCalendar object)
 */
class qCal_Component {

	/**
	 * The name of this component
	 */
	protected $name;
	/**
	 * All components (other than calendars) are children of
	 * another component. Most components are nested within the calendar
	 * component, but alarms can be children of events, etc.
	 */
	protected $children;
	/**
	 * Components are made up of properties. Properties define how a component
	 * is supposed to behave.
	 */
	protected $properties;
	/**
	 * Contains a list of allowed parent components. If an attempt
	 * to nest this component into another that is not in this list is
	 * made, a qCal_Exception_CannotNestComponent will be thrown.
	 */
	protected $allowedParents = array();
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

}