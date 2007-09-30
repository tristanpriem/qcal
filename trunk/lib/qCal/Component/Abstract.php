<?php

/**
 * qCal iCalendar library - abstract component
 * Please read the LICENSE file
 * @author Luke Visinoni <luke@mc2design.com>
 * @author Josh Davies <josh@mc2design.com>
 * @package qCal
 * @license GNU Lesser General Public License
 */

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
		if ((array_key_exists(strtoupper($key), $this->_allowedProperties)) // METHOD
		{
			if($key ! only_allowed_once)
			{
				// create an array if it doesn't exist inside the properties property
				if (!is_array($this->_properties[$key]) $this->_properties[$key] = array();
				// now add to the properties ($key) array
				$this->_properties[$key][] = $val;
			}
			else
			{
				// overwrite value in $this->_properties[$key]
			}
		}
	}
    
    public function addProperty()
    {
    }
}	

