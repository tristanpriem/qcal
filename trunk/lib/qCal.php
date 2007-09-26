<?php
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
     * Contains the log entries
     *
     * @var array
     */
    protected $_log = array();
    
    protected $_name = 'vcalendar';
    protected $_allowedProperties = array ();
    protected $_allowedComponents = array ();
    
    /**
     * Class constructor - instantiates object
     *
     * @var none
     */
    public function __construct()
    {
        $this->_allowedProperties = qCal_rfc2445::getAllowedParams($this->_name);
        $this->_allowedComponents = qCal_rfc2445::getAllowedComponents($this->_name);
        $this->setParam('prodid', '-//MC2 Design Group, Inc.//qCal v' . self::VERSION . '//EN');
    }
    /**
     *
     * @var $param version number or range
     */
    public function setParam($param, $value)
    {
        if (!qCal_rfc2445::isValidVersion($version))
        {
            $this->_log[] = 'Version "' . $version . '" is not an rfc2445-compliant version number';
        }
    }
}