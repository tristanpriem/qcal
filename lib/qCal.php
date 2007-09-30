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

require_once 'qCal/rfc2445.php';
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
     * Per RFC
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
    // I stole this idea from bennu :(
    protected $_allowedProperties = array ();
    protected $_allowedComponents = array (); 
    /**
     * Class constructor - instantiates object
     *
     * @var none
     */
    public function __construct()
    {
        $this->_allowedProperties = array(
            'CALSCALE' => self::OPTIONAL | self::ONCE, // binary 0011
            'METHOD' => self::OPTIONAL | self::ONCE, // binary 0011
            'PRODID' => self::REQUIRED | self::ONCE, // binary 0101
            'VERSION' => self::REQUIRED | self::ONCE // binary 0101
            // need to allow x-name properties also
        );
        // can be overwritten
        $this->setProperty('prodid', '-//MC2 Design Group, Inc.//qCal v' . self::VERSION . '//EN');
    }
}
