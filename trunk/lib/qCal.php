<?php
require_once 'qCal/rfc2445.php';
require_once 'qCal/Component/Abstract.php';

class qCal extends qCal_Component_Abstract
{
    /**
     * Internet standard newline
     */
    const LINE_ENDING = "\r\n";
    /**
     * Version of this library
     *
     * @var string
     */
    const VERSION = '0.01';
    /**
     * The longest a line can be before it must be folded
     */
    const LINE_FOLD_LENGTH  = 75;
    const PROPERTY_OPTIONAL = 1; // binary 0001
    const PROPERTY_ONCE     = 2; // binary 0010
    const PROPERTY_REQUIRED = 3; // binary 0100
    /**
     * Contains the name of this component
     *
     * @var array
     */
    protected $_name = 'VCALENDAR';
    // I stole this idea from bennu :(
    protected $_allowedProperties = array (
        'CALSCALE' => self::PROPERTY_OPTIONAL | self::PROPERTY_ONCE,
        'METHOD' => self::PROPERTY_OPTIONAL | self::PROPERTY_ONCE,
        'PRODID' => self::PROPERTY_REQUIRED | self::PROPERTY_ONCE,
        'VERSION' => self::PROPERTY_REQUIRED | self::PROPERTY_ONCE
        // need to allow x-name properties also
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
        $this->setProperty('prodid', '-//MC2 Design Group, Inc.//qCal v' . self::VERSION . '//EN');
    }
    /**
     * Tells whether a version is valid according to the rfc
     * @var string $version  The version number we're validating
     * @return bool
     * @todo: implement this
     */
    public static function isValidVersion($version)
    {
        return true;
    }
}