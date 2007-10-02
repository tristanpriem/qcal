<?php

/**
 * qCal iCalendar library - property factory
 * Please read the LICENSE file
 * @author Luke Visinoni <luke@mc2design.com>
 * @author Josh Davies <josh@mc2design.com>
 * @package qCal
 * @license GNU Lesser General Public License
 */

class qCal_Property_Factory
{
    /**
     * Factory method - given a property name, it will create an instance of said
     * property's respective class.
     * 
     * @param $property - property name
     * @returns false|qCal_Property_Abstract
     * @throws qCal_Component_Exception
     */
    public static function createInstance($property, $value = null)
    {
        $classname = 'qCal_Property_' . strtolower($property);
        $path = './' . str_replace('_', '/', $classname) . '.php';
        if ($includepath = self::canInclude($path))
        {
            require_once $includepath;
            if (class_exists($classname)) return new $classname($value);
        }
        throw new qCal_Component_Exception('"' . $property . '" is not a valid property name');
    }
    /**
     * Can we include this file? (since apparently php doesn't search the current
     * path first and then look in the include paths... LAME!
     * 
     * @param $filename - the name of the file you need to include
     * @returns false|string - "includeable" path to the file
     */
    public static function canInclude($filename)
    {
        $include_paths = explode(PATH_SEPARATOR, get_include_path());

        foreach ($include_paths as $path) {
            $include = $path.DIRECTORY_SEPARATOR.$filename;
            if (is_file($include) && is_readable($include))
            {
                return $include;
            }
        }
        return false;
    }
}