<?php

/**
 * qCal iCalendar library - prodid property
 * Please read the LICENSE file
 * @author Luke Visinoni <luke@mc2design.com>
 * @author Josh Davies <josh@mc2design.com>
 * @package qCal
 * @license GNU Lesser General Public License
 */

require_once 'Abstract.php';

class qCal_Property_version extends qCal_Property_Abstract
{
    /**
     * Verify that the value in this property conforms with rfc 2445
     * @returns boolean
     */
    protected function evaluateIsValid()
    {
        // @todo: make sure this fits the rfc
        return preg_match('/^[0-9]+\.[0-9]{1,2}(\/[0-9]+\.[0-9]{1,2})?$/', $this->_value, $matches);
    }
    protected function format($value)
    {
        $value = (string) $value;
        // if there is no dot in the version, add one
        if (!strpos($value, '.'))
        {
            $value .= '.0';
        }
        return $value;
    }
}