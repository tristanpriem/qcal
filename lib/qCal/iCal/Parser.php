<?php

/**
 * qCal iCalendar library - icalendar parser
 * Please read the LICENSE file
 * @author Luke Visinoni <luke@mc2design.com>
 * @author Josh Davies <josh@mc2design.com>
 * @package qCal
 * @license GNU Lesser General Public License
 */

require_once 'qCal.php';

class qCal_iCal_Parser
{
    /**
     * Contains every line in the file
     *
     * @var array
     */
    protected $_lines = array();
    /**
     * qCal object - holds the calendar abject to return
     *
     * @var qCal object
     */
    protected $_cal;
    /**
     * Constructor - initializes the object
     *
     * @var $filename filename of ical file
     */
    public function __construct($filename = null)
    {
        // get an array of all lines in the file
        $this->_lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        // remove newlines
        $this->_cal = new qCal();
    }
    
    public function parse()
    {
        foreach ($this->_lines as $line)
        {
            list($param, $val) = explode(":", $line);
            switch (strtolower($param))
            {
                case 'begin':
                    // need to generate a component object based on value of $val
                    break;
                case 'version':
                    // need to set version on qCal Component
                    $this->_cal->setProperty('version', $val);
                    break;
            }
        }
    }
}
