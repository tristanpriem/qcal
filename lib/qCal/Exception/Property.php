<?php
/**
 * This is used for property-related exceptions
 */
class qCal_Exception_Property extends qCal_Exception {

	protected $property;
	/**
	 * Replaces {PROPERTY} with the property name. This is so that when reporting messages,
	 * you can simply do throw new qCal_Property_Exception("{PROPERTY} did something wrong");
	 */
	public function setMessage($message) {
	
		if ($this->property instanceof qCal_Property) {
			$message = str_replace("{PROPERTY}", $this->property->getName(), $message);
		}
		return parent::setMessage($message);
	
	}
	
	public function setProperty(qCal_Property $property) {
	
		$this->property = $property;
	
	}
	
	public function getProperty() {
	
		return $this->property;
	
	}

}