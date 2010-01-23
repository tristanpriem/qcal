<?php
/**
 * This is the abstract class that all other recurrence rule classes must
 * inherit.
 */
abstract class qCal_DateTime_Recur_Rule {

	protected $name;
	
	protected $value;
	
	public function __construct($value, $name = null) {
	
		$this->setValue($value)
			->setName($name);
	
	}
	
	/**
	 * Set the name of the rule. If the rule is not explicitly given a name,
	 * it will be derived from parts of the class name, and maybe the value
	 */
	public function setName($name = null) {
	
		if (is_null($name)) {
			$name = $this->generateName();
		}
		$this->name = (string) $name;
		return $this;
	
	}
	
	public function getName() {
	
		return $this->name;
	
	}
	
	public function getValue() {
	
		return $this->value;
	
	}
	
	public function __toString() {
	
		return implode(",", $this->value);
	
	}
	
	/**
	 * Set the value for this rule. This is a very basic method. Although some
	 * of the rule classes use it, most of them extend it.
	 */
	public function setValue($value) {
	
		if (!is_array($value)) {
			if (strpos($value, ",")) {
				$value = explode(",", $value);
			} else {
				$value = array((string) $value);
			}
		}
		$this->value = $value;
		return $this;
	
	}
	
	protected function generateName() {
	
		$name = array_pop(explode("_", get_class($this)));
		return $name;
	
	}

}