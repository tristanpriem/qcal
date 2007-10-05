<?php

/**
 * qCal iCalendar library - calendar component
 * Please read the LICENSE file
 * @copyright MC2 Design Group, Inc. <info@mc2design.com>
 * @author Luke Visinoni <luke@mc2design.com>
 * @author Josh Davies <josh@mc2design.com>
 * @package qCal
 * @license GNU Lesser General Public License
 */

require_once 'qCal/Component.php';

class qCal_Component_vcalendar extends qCal_Component_Abstract
{
    /**
     * Contains the name of this component
     *
     * @var array
     */
    protected $_name = 'VCALENDAR';
    /**
     * Initialize this object
     *
     * @var none
     */
    public function init()
    {
        // can be overwritten
        $this->addProperty('prodid', '-//MC2 Design Group, Inc.//qCal v' . qCal::VERSION . '//EN');
        $this->addProperty('version', '2.0');
    }
    public function __toString()
    {
		header('Content-Type: ' . qCal::CONTENT_TYPE . '; charset=' . qCal::charset());
        return parent::__toString();
    }
}
