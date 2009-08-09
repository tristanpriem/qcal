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
	/**
	 * @todo I'm not sure I like how this is done. Eventually I will come back to it.
	 */
	public function setValue($value) {
	
		if (!is_array($value)) {
			$value = array($value);
		}
		// if value sent is null and this property doesn't have a default value,
		// the property can't be created, so throw an invalidpropertyvalue exception
		parent::setValue($value);
		$values = array();
		foreach ($value as $val) {
			$values[] = qCal_Value::factory($this->getType(), $val);
		}
		$this->value = $values;
		return $this;
	
	}

}