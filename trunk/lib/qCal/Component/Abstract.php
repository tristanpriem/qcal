<?php

/**
 * qCal iCalendar library - abstract component
 * Please read the LICENSE file
 * @author Luke Visinoni <luke@mc2design.com>
 * @author Josh Davies <josh@mc2design.com>
 * @package qCal
 * @license GNU Lesser General Public License
 */

require_once 'qCal.php';
require_once 'qCal/Component/Exception.php';
require_once 'qCal/Property/Factory.php';

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
     * properties, etc. - see comments in __construct for more info
     */
    abstract protected function init();
	/**
	 * Add a property for this component. Parameters can only be set if their key
	 * is in $this->_allowedProperties and if they comply with RFC 2445
	 * 
	 * @var name - the property name we are trying to set
     * @var value - the value of the property
     */
	public function addProperty($name, $value)
	{
        if ($this->isValidProperty($name, $value))
        {
            $this->_properties[$name] = qCal_Property_Factory::createInstance($name, $value);
        }
	}
	/**
	 * Retrieve a property from this component
	 * 
	 * @var name - the property name we are trying to set
     */
	public function getProperty($name)
	{
        if (array_key_exists($name, $this->_properties))
        {
            return $this->_properties[$name];
        }
        return null;
	}
	/**
	 * Verifies a property for this component - first checks that the key is in 
     * allowedProperties, and then if it is, creates a property object and validates
	 * 
	 * @var name - the property name we are trying to set
     * @var value - the value of the property
     */
    protected function isValidProperty($name, $value)
    {
        // per rfc 2445 - property names are to be capitalized
        $name = strtoupper($name);
        // check that property ($name) is allowed to be set on this component
		if (in_array($name, $this->_allowedProperties))
		{
            try {
                $property = qCal_Property_Factory::createInstance($name, $value);
                return $property->isValid();
            } catch (qCal_Component_Exception $e) {
                // @todo: maybe log that this happened so the user can figure it out?
                // @todo: qCal_Logger - qCal_Logger::setOptions(); qCal_Logger::getLog()
                return false;
            }
		}
        return false;
    }
    
    public function serialize()
    {
        $output = '';
        //foreach ($this->
    }
    
    public function __toString()
    {
        header('Content-Type: ' . qCal::CONTENT_TYPE . '; charset=' . qCal::charset());
        return $this->serialize();
    }
}	

