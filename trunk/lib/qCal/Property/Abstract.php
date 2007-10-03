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
        return (string) $this->_value;
    }
    /**
     * Validation logic that happens to ALL properties - we want to make sure user
     * cannot extend this method - set as final because child classes implement
     * evaluateIsValid, not isValid()
     * 
     * @returns bool
     */
    final public function isValid()
    {
        // @todo: add global property validation
        return $this->evaluateIsValid();
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