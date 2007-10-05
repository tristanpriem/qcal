<?php

/**
 * qCal iCalendar library - icalendar property (abstract)
 * Please read the LICENSE file
 * @author Luke Visinoni <luke@mc2design.com>
 * @author Josh Davies <josh@mc2design.com>
 * @package qCal
 * @license GNU Lesser General Public License
 */

require_once 'qCal/Component/Exception.php';
 
abstract class qCal_Property_Abstract
{
    /**
     * Property's value - defaults to null
     */
    protected $_value;
    /**
     * Property's name
     */
    protected $_name;
    /**
     * Is this property required?
     */
    protected $_required = true;
    /**
     * Is this property allowed more than once?
     */
    protected $_multiple = false;
    /**
     * The components this is allowed to attach to
     */
    protected $_validParents = array();
    /**
     * Class constructor 
     */
    public function __construct($value = null)
    {
        $this->setValue($value);
    }
    /**
     * Should you forget to set the value upon instantiation, you can set it here
     * 
     * @param $value - the value of the property
     */
    public function setValue($value)
    {
        $this->_value = $this->format($value);
    }
    /**
     * Magic PHP method - outputs $this->_value as a string
     * 
     * @returns string
     */
    public function __toString()
    {
        return (string) $this->getValue();
    }
    protected function getValue()
    {
        return $this->_value;
    }
    public function getName()
    {
        return strtoupper($this->_name);
    }
    /**
     * Pass in a property name and this will tell you whether this property is of that type
     */
    public function isA($name)
    {
        return $this->getName() == strtoupper($name);
    }
    public function serialize()
    {
        return $this->getName() . ':' . $this->getValue();
    }
    /**
     * Is the component this is being added to allowed?
     */
    public function allowsParent(qCal_Component_Abstract $component)
    {
        return (in_array($component->getType(), $this->_validParents));
    }
    /**
     * Validation logic that happens to ALL properties - we want to make sure user
     * cannot extend this method - set as final because child classes implement
     * evaluateIsValid, not isValid()
     *
     * the component uses this method to verify that a property can be added to it
     * so the component this property lives in is passed as a parameter. this way
     * you can tell if it is 
     * required for the component it is set on
     * 
     * @returns bool
     */
    final public function isValid(qCal_Component_Abstract $component)
    {
        // if this is required and it's not set, return false
        if (!$component->hasProperty($this->_name) && $this->_required) return false;
        // @todo: add global property validation
        return $this->evaluateIsValid();
    }
    
    // tells whether this property can be attached to a parent component
    public function canAttachTo(qCal_Component_Abstract $component)
    {
        // if this parent is allowed this property, and 
        if (!$this->allowsParent($component))
        {
            throw new qCal_Component_Exception('Property ' . $this->_name . ' may not be set on a ' . $component->getType() . ' component');
        }
        return true;
    }
    /**
     * Any formatting that should be done on the value is done here
     * (kind of like a filter) - it defaults to no formatting
     * 
     * @param $value - the value of the property
     */
    abstract protected function format($value);
    /**
     * All validation logic should be applied here. Objects such as qCal_Property_prodid
     * will extend this class and implement this method
     * 
     * @returns bool
     */
    abstract protected function evaluateIsValid();
}