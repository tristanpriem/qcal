<?php
/**
 * Categories Property
 * @package qCal
 * @copyright Luke Visinoni (luke.visinoni@gmail.com)
 * @author Luke Visinoni (luke.visinoni@gmail.com)
 * @license GNU Lesser General Public License
 */
class qCal_Property_MultiValue extends qCal_Property {

	/**
	 * Property value
	 * @var qCal_Value object
	 */
	protected $value = array();
	/**
	 * MultiValue properties contain an array of values rather than one, so we
	 * store them in an array and return them comma-separated.
	 */
	public function getValue() {
	
		$return = array();
		foreach ($this->value as $value) {
			$return[] = $value->__toString();
		}
		return implode(chr(44), $return);
	
	}

}