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
require_once 'qCal/Exception.php';
require_once 'qCal/Attachable.php';
require_once 'qCal/Property/Factory.php';

// @todo: I was pondering the idea of changing the structure of things a bit I was
// thinking that it may be a good idea to make qCal not actually a qCal component
// but instead create an object called qCal_Component_icalendar since you can 
// actually add more than one icalendar object in the rfc - I am definitely going
// to do this - then qCal will be more of just a container of components - in order
// to do this though we'll need to make absolute sure that you are allowed to add
// more than one icalendar object to an icalendar file

abstract class qCal_Component extends qCal_Attachable
{
    const BEGIN = 'BEGIN:';
    const END = 'END:';
    // @todo: research the possibility of merging these two as $_children
    protected $_properties = array();
    protected $_components = array();
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
     * Initialize your component.
     */
    protected function init()
    {
    }
    /**
     * Get the type of component
     */
    public function getType()
    {
        return strtoupper($this->_name);
    }
    /**
     * Add a property for this component. Parameters can only be set if this component
     * is in their _validParents array
     * 
     * @var value - the value of the property
     */
    public function addProperty($property, $value = null)
    {
        if (is_string($property))
        {
            // createInstance creates a property object from property's internal name
            $property = qCal_Property_Factory::createInstance($property, $value);
        }
        
        // if this parent is allowed this property, and 
        if (!$property->allowsParent($this))
        {
            throw new qCal_Exception('Property ' . $property->getType() . ' may not be set on a ' . $this->getType() . ' component');
        }
        if ($this->hasProperty($property->getType()))
        {
            if (!$property->isMultiple())
            {
                throw new qCal_Exception('Property ' . $property->getType() . ' is already set and does not allow multiple values');
            }
            if ($localProperty = $this->getProperty($property->getType()))
            {
                $localProperty->addValue($property->getValue());
            }
        }
        $this->_properties[] = $property;
    }
    public function removeProperty($name)
    {
        foreach ($this->_properties as $key => $property)
        {
            // returns first property of correct type
            // still am not sure if properties can be set multiple times - luke
            if ($property->getType() == $name) unset($this->_properties[$key]);
        }
    }
    /**
     * Retrieve a property from this component
     * 
     * @var name - the property name we are trying to get
     */
    public function getProperty($name)
    {
        foreach ($this->_properties as $property)
        {
            // returns first property of correct type
            // still am not sure if properties can be set multiple times - luke
            if ($property->getType() == $name) return $property;
        }
    }
    /**
     * Check if  a property is in this component
     * 
     * @var name - the property name
     */
    public function hasProperty($name)
    {
        foreach ($this->_properties as $property)
        {
            // returns first property of correct type
            // properties who can be set multiple times will get an object back with multiple values
            if ($property->getType() == $name) return true;
        }
    }
    /**
     * Add a component for this component. Components can only be set if their type
     * is in $this->_allowedComponents and if they comply with RFC 2445
     * 
     * @var name - the component name we are trying to set
     * @var value - the value of the component
     */
    public function addComponent(qCal_Component $component)
    {
        /*I changed the arguments for this, it seemed like it wouldn't
         * be uncommon to not need a name when the object is added.
         * I'm willing to admit I could be totally wrong here :)
         *  
         * nope, you're absolutely right - nice catch
         * in fact, a key is completely unnecessary  - luke :)
         * ***********************************************************/
         
         // by the way, from now on if you want to add comments just do it like this
         // the comments above the methods are written like that because they are what
         // is called docblocks. look up "php docblocks" on google - luke
        $this->_components[] = $component;
    }
    /**
     * Retrieve a component from this component
     * 
     * @var name - the component name we are trying to get
     */
    public function getComponent($name)
    {
        foreach ($this->_components as $component)
        {
            // returns first property of correct type
            // still am not sure if properties can be set multiple times - luke
            if ($component->getType() == $name) return $component;
        }
    }
    public function serialize()
    {
        $lines = array();
        // uppercase the name of this component
        $lines[] = strtoupper(self::BEGIN . $this->_name);

        // add this component's (... component's what?-JD)
        foreach ($this->_properties as $property) $lines[] = $property->serialize();
        foreach ($this->_components as $component) $lines[] = $component->serialize();

        $lines[] = self::BEGIN . $name;
        return implode(qCal::LINE_ENDING, $lines);
    }
    /**
     * PHP overload function - prints out the component
     *
     * @returns boolean
     */
    public function __toString()
    {
        return $this->serialize();
    }
}
