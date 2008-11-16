<?php
/**
 * This is used for component-related exceptions
 */
class qCal_Exception_Component extends qCal_Exception {

	protected $component;
	/**
	 * Replaces {COMPONENT} with the component name. This is so that when reporting messages,
	 * you can simply do throw new qCal_Component_Exception("{COMPONENT} did something wrong");
	 */
	public function setMessage($message) {
	
		if ($this->component instanceof qCal_Component) {
			$message = str_replace("{COMPONENT}", $this->component->getName(), $message);
		}
		return parent::setMessage($message);
	
	}
	
	public function setComponent(qCal_Component $component) {
	
		$this->component = $component;
	
	}
	
	public function getComponent() {
	
		return $this->component;
	
	}

}