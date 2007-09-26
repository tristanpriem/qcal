<?php

abstract class qCal_Component_Abstract
{
    protected $_name = null;
    protected $_properties = array();
    protected $_components = array();
    protected $_allowedProperties = array();
    protected $_allowedComponents = array();
    /**
     * Set a parameter for this calendar. Parameters can only be set if their key
     * is in $this->_allowedProperties
     * 
     * @var $param version number or range
     */
    public function setProperty($key, $value)
    {
        $key = strtoupper($key);
        if (array_key_exists($key, $this->_allowedProperties))
        {
            $this->_properties[$key] = $value;
        }
    }
}