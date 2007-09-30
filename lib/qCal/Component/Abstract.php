<?php

/**
 * qCal iCalendar library - abstract component
 * Please read the LICENSE file
 * @author Luke Visinoni <luke@mc2design.com>
 * @author Josh Davies <josh@mc2design.com>
 * @package qCal
 * @license GNU Lesser General Public License
 */

require_once 'qCal/Component/Exception.php';

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
     * @throws qCal_Component_Exception
     */
	public function addProperty($key, $value)
	{
        if (!$this->isValidProperty($key, $value))
        {
            throw new qCal_Component_Exception('"' . $key . '" is not an allowed property for a ' . $this->_name);
        }
	}
    
    protected function isValidProperty($key, $value)
    {
        $key = strtoupper($key);
		if (!array_key_exists($key, $this->_allowedProperties)
		{
            return false;
		}
    }
}	

