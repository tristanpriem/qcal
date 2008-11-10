<?php

/**
 * qCal iCalendar library - prodid property
 * Please read the LICENSE file
 * @author Luke Visinoni <luke@mc2design.com>
 * @author Josh Davies <josh@mc2design.com>
 * @package qCal
 * @license GNU Lesser General Public License
 */

require_once 'qCal/Property.php';

class qCal_Property_calscale extends qCal_Property
{
    protected $_name = 'CALSCALE';
    protected $_validParents = array('VCALENDAR');
    /**
     * Verify that the value in this property conforms with rfc 2445
     * @returns boolean
     */
    protected function evaluateIsValid()
    {
        // @todo: find out how to validate this value
        return true;
    }
    protected function format($value)
    {
        // @todo: find out how to format this value
        // formatting comes BEFORE validation fyi - luke
        return $value;
    }
}