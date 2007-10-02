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

require_once 'qCal/Component/Abstract.php';

class qCal extends qCal_Component_Abstract
{
    /**
     * Version of this library
     *
     * @var string
     */
    const VERSION = '0.01';
    /**
     * Internet standard newline
     */
    const LINE_ENDING = "\r\n";
    /**
     * Per RFC 2445
     */
    const CONTENT_TYPE = "text/calendar";
    /**
     * The longest a line can be before it must be folded
     */
    const LINE_FOLD_LENGTH  = 75;
    /**
     * Flags for allowed properties / com
     */
    const OPTIONAL = 1; // binary 0001
    const ONCE     = 2; // binary 0010
    const REQUIRED = 3; // binary 0011
    /**
     * Contains the name of this component
     *
     * @var array
     */
    protected $_name = 'VCALENDAR';
    /**
     * @todo: add support for x-name properties
     * @todo: find all allowed properties in rfc
     */
    protected $_allowedProperties = array('CALSCALE', 'METHOD', 'PRODID', 'VERSION');
    /**
     * @todo: add support for x-name properties
     * @todo: find all allowed components in rfc
     */
    protected $_allowedComponents = array('VEVENT', 'VTODO', 'VJOURNAL', 'VALARM');
    protected static $_charset = null;
    /**
     * Initialize this object
     *
     * @var none
     */
    public function init()
    {
        // can be overwritten
        $this->addProperty('prodid', '-//MC2 Design Group, Inc.//qCal v' . self::VERSION . '//EN');
        $this->addProperty('version', '2.0');
    }
    /**
     * Get character set for this calendar
     * 
     * @var default - if charset has not been set use this
     */
    public static function charset($default = 'utf-8')
    {
        return is_null(self::$_charset) ? $default : self::$_charset;
    }
}
