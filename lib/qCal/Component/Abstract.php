<?php

/**
 * qCal iCalendar library - abstract component
 * Please read the LICENSE file
 * @author Luke Visinoni <luke@mc2design.com>
 * @author Josh Davies <josh@mc2design.com>
 * @package qCal
 * @license GNU Lesser General Public License
 */

require_once 'qCal/Component/Exception.php';

abstract class qCal_Component_Abstract
{
	protected $_name = null;
	protected $_properties = array();
	protected $_components = array();
	protected $_allowedProperties = array();
	protected $_allowedComponents = array();
    /**
     * Relay initialization to an init() method so that children can do initialization
     * and not risk forgetting a parent::__construct()
     * this is just an idea at this point... it may not be necessary - it will only be
     * necessary if there is something in __construct that needs to be done every time
     */
    public function __construct()
    {
        $this->init();
    }
    /**
     * Initialize your component. This is where you set the allowable components, 
     * properties, etc.
     */
    abstract protected function init();
	/**
	 * Add a property for this component. Parameters can only be set if their key
	 * is in $this->_allowedProperties and if they comply with RFC 2445
	 * 
	 * @var key - the property name we are trying to set
     * @var value - the value of the property
     */
	public function addProperty($key, $value)
	{
        if ($this->isValidProperty($key, $value))
        {
            $this->_properties[$key] = $value;
        }
	}
	/**
	 * Verifies a property for this component - first checks that the key is in 
     * allowedProperties, and then if it is, creates a property object and validates
	 * 
	 * @var key - the property name we are trying to set
     * @var value - the value of the property
     */
    protected function isValidProperty($key, $value)
    {
        $key = strtoupper($key);
		if (array_key_exists($key, $this->_allowedProperties)
		{
            $property = qCal_Component_Abstract::factory($key);
            return $property->isValid($value);
		}
        return false;
    }
}	

