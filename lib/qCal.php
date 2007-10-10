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

require_once 'qCal/Component/vcalendar.php';
 
class qCal
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
     * Character set of this object
     */
    protected static $_charset = null;
    /**
     * You cannot instantiate this object - use qCal::create()
     */
    private function __construct() { }
    /**
     * You cannot instantiate this object since it isn't a component
     * This method returns an actual vcalendar component
     * while I don't especially like this... I don't know any way around it
     */
    public static function create()
    {
        return new qCal_Component_vcalendar();
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
