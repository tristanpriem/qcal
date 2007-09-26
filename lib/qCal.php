<?php
require_once 'qCal/rfc2445.php';

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
    
    protected $_name = 'VCALENDAR';
    protected $_allowedProperties = array (
        
    );
    protected $_allowedComponents = array (
        
    );
    
    /**
     * Class constructor - instantiates object
     *
     * @var none
     */
    public function __construct()
    {
        $this->_prodid = '-//MC2 Design Group, Inc.//qCal v' . self::VERSION . '//EN';
    }
    /**
     *
     * @var $param version number or range
     */
    public function setParameter($param, $value)
    {
        if (!qCal_rfc2445::isValidVersion($version))
        {
            $this->_log[] = 'Version "' . $version . '" is not an rfc2445-compliant version number';
        }
    }
}