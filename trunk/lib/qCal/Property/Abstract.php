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
        $this->_value = $value;
    }
    /**
     * All validation logic should be applied here. Objects such as qCal_Property_prodid
     * will extend this class.
     * 
     * @returns bool
     */
    abstract public function isValid();
    public function __toString()
    {
        return (string) $this->_value;
    }
}