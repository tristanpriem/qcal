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
     * Add a property/component to this component. Can only be set if this component
     * is in the attachable's _validParents array
     * 
     * @var value - the value of the property
     */
    public function attach($attachable, $value = null)
    {
        if (is_string($attachable))
        {
            // createInstance creates a property/component object from property/component's internal name
            $attachable = qCal_Attachable_Factory::createInstance($attachable, $value);
        }
        if (!$attachable instanceof qCal_Attachable)
        {
            d(get_class($attachable));
            d($attachable);
            exit;
            throw new qCal_Exception($attachable . ' must be an instance of qCal_Attachable');
        }
        
        // if this parent is allowed this property, and 
        if (!$attachable->allowsParent($this))
        {
            throw new qCal_Exception('A ' . $attachable . ' may not be set on a ' . $this);
        }
        if ($this->has($attachable->getType()))
        {
            if (!$attachable->isMultiple())
            {
                throw new qCal_Exception('A ' . $attachable . ' is already set and does not allow multiple values');
            }
            if ($localattachable = $this->get($attachable->getType()))
            {
                $localattachable->addValue($attachable);
            }
        }
        $this->_children[] = $attachable;
    }
    public function remove($name)
    {
        foreach ($this->_children as $key => $child)
        {
            // removes first property of correct type
            if ($child->getType() == $name) unset($this->_children[$key]);
        }
    }
    /**
     * Retrieve a property/component from this component
     * 
     * @var name - the property name we are trying to get
     */
    public function get($name)
    {
        foreach ($this->_children as $child)
        {
            // returns first property of correct type
            // properties who can be set multiple times will get an object back with multiple values
            if ($child->getType() == $name) return $child;
        }
    }
    /**
     * Check if  a property/component is in this component
     * 
     * @var name - the property name
     */
    public function has($name)
    {
        foreach ($this->_properties as $property)
        {
            // returns first property of correct type
            if ($property->getType() == $name) return true;
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

