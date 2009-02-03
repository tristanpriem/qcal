<?php
/**
 * Multiple Values
 * 
 * Some properties defined in the iCalendar object can have multiple
 * values. The general rule for encoding multi-valued items is to simply
 * create a new content line for each value, including the property
 * name. However, it should be noted that some properties support
 * encoding multiple values in a single property by separating the
 * values with a COMMA character (US-ASCII decimal 44). Individual
 * property definitions should be consulted for determining whether a
 * specific property allows multiple values and in which of these two
 * forms.
 */
abstract class qCal_Value_Multi extends qCal_Value {

	/**
	 * Property value
	 * @var array of qCal_Value objects
	 */
	protected $value = array();
	/**
	 * Sets the property value (or values in this case)
	 * @param mixed
	 */
	public function setValue($values) {
	
        // remove current values
        $this->value = array();
		if (is_array($values)) {
            foreach ($values as $value) {
                $this->addValue($value);
            }
        } else {
			$this->addValue($values);
		}
	
	}
	/**
	 * Add to list of values
	 */
    public function addValue($value) {
    
		$this->value[] = $this->doCast($value);
    
    }
	/**
	 * Returns the value as a string
	 */
	public function __toString() {
	
		$strings = array();
		foreach ($this->value as $value) {
			$strings[] = $this->toString($value);
		}
		return implode(",", $strings);
	
	}
	/**
	 * Returns raw value (as it is stored). If there is only one value, it returns it,
	 * otherwise it returns an array
	 */
	public function getValue() {
	
		if (count($this->value) == 1) return current($this->value);
		return $this->value;
	
	}

}