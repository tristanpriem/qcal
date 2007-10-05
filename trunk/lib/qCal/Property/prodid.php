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

class qCal_Property_prodid extends qCal_Property_Abstract
{
    protected $_name = 'PRODID';
    protected $_validParents = array('VCALENDAR');
    /**
     * @todo: add body to this method
     */
    protected function evaluateIsValid()
    {
        return true;
    }
    protected function format($value)
    {
        return $value;
    }
}