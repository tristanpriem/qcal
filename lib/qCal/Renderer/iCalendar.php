<?php
/**
 * Default icalendar renderer. Pass a component to the renderer, and it will render it in accordance with rfc 2445
 * @package qCal
 * @copyright Luke Visinoni (luke.visinoni@gmail.com)
 * @author Luke Visinoni (luke.visinoni@gmail.com)
 * @license GNU Lesser General Public License
 */ 
class qCal_Renderer_iCalendar extends qCal_Renderer {

	const LINE_ENDING = "\r\n";
	/**
	 * Render any component
	 */
	public function render(qCal_Component $component) {
	
		$return = "BEGIN:" . $component->getName() . self::LINE_ENDING;
		foreach ($component->getProperties() as $property) $return .= $this->renderProperty($property);
		foreach ($component->getChildren() as $children) {
			if (is_array($children)) {
				foreach ($children as $child) {
					$return .= $this->render($child);
				}
			} else {
				$return .= $this->render($children);
			}
		}
		return $return . "END:" . $component->getName() . self::LINE_ENDING;
	
	}
	/**
	 * Renders a property in accordance with rfc 2445
	 */
	protected function renderProperty(qCal_Property $property) {
	
		$propval = $property->getValue();
		$params = $property->getParams();
		$paramreturn = "";
		foreach ($params as $paramname => $paramval) {
			$paramreturn .= ";" . $paramname . "=" . $paramval;
		}
		return $property->getName() . $paramreturn . ":" . $this->renderValue($propval, $property->getType()) . self::LINE_ENDING;
	
	}
	/**
	 * Render $value as $type - this function uses the datatype to know how to render a value
	 * @return mixed
	 * @todo implement this
	 */
	protected function renderValue($value, $type) {
	
		switch (strtoupper($type)) {
			default:
				return $this->fold($value);
		}
	
	}
	
	/**
	 * Text cannot exceed 72 octets. This method will "fold" long lines in accordance with RFC 2445
	 */
	protected function fold($data) {
	
		$apart = str_split($data, 72);
		return implode(self::LINE_ENDING . " ", $apart);
	
	}
	/**
	 * Unfold "folded" text
	 */
	protected function unfold($data) {
	
		
	
	}

}