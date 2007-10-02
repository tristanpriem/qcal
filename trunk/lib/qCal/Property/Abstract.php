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
     * All validation logic should be applied here. Objects such as qCal_Property_prodid
     * will extend this class.
     * 
     * @param $value - the value to be validated
     * @returns bool
     */
    abstract public function isValid($value);
    /**
     * Factory method - given a property name, it will create an instance of said
     * property's respective class.
     * 
     * @param $key - property name
     * @returns false|qCal_Property_Abstract
     * @throws qCal_Component_Exception
     */
    public static function factory($key)
    {
        $classname = 'qCal_Property_' . strtolower($key);
        $filename = str_replace('_', '/', $classname);
        $filename .= '.php';
        if (file_exists($filename))
        {
            require_once $filename;
            return new $classname;
        }
        return false;
    }
}