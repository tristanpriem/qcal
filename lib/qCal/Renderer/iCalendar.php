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
			$paramreturn .= $this->renderParam($paramname, $paramval);
		}
		// if property has a "value" param, then use it as the type instead
		$proptype = isset($params['VALUE']) ? $params['VALUE'] : $property->getType();
		$content = $property->getName() . $paramreturn . ":" . $property->getValue() . self::LINE_ENDING;
		// @todo: I'm fairly sure that this is supposed to fold EVERYTHING, but not positive
		return $this->fold($content);
	
	}
	/**
	 * Renders a parameter
	 * RFC 2445 says if paramval contains COLON (US-ASCII decimal
	 * 58), SEMICOLON (US-ASCII decimal 59) or COMMA (US-ASCII decimal 44)
	 * character separators MUST be specified as quoted-string text values
	 */
	protected function renderParam($name, $value) {
	
		$invchars = array(chr(58),chr(59),chr(44));
		$quote = false;
		foreach ($invchars as $char) {
			if (strstr($value, $char)) {
				$quote = true;
				break;
			}
		}
		if ($quote) $value = '"' . $value . '"';
		return ";" . $name . "=" . $value;
	
	}
	/**
	 * Render $value as $type - this function uses the datatype to know how to render a value
	 * @return mixed
	 * @todo I don't think we need this any more
	 */
	protected function renderValue($value, $type) {
	
		/*
		switch (strtoupper($type)) {
			case "BINARY":
				$value = base64_encode($value);
				break;
			case "BOOLEAN":
				$value = ($value) ? "TRUE" : "FALSE";
				break;
			case "CAL-ADDRESS":
				// @todo: I don't know what to do here yet
			    break;
			case "DATE":
				// @todo: I don't know what to do here yet
				break;
			case "DATE-TIME":
				// @todo: I don't know what to do here yet
				break;
			case "DURATION":
				// @todo: I don't know what to do here yet
				break;
			case "FLOAT":
			case "INTEGER":
				// returns "2.1" for 2.1 etc.
				$value = (string) $value;
				break;
			case "PERIOD":
				// @todo: I don't know what to do here yet
				break;
			case "RECUR":
				// @todo: I don't know what to do here yet
				break;
			case "TIME":
				// @todo: I don't know what to do here yet
				break;
			case "URI":
				// @todo: I don't know what to do here yet
				break;
			case "UTC-OFFSET":
				// @todo: I don't know what to do here yet
				break;
			case "TEXT":
			default:
			    break;
		}
		return $value;
	    */
	
	}
	
	/**
	 * Text cannot exceed 72 octets. This method will "fold" long lines in accordance with RFC 2445
	 */
	protected function fold($data) {
	
		if (strlen($data) == (72 + strlen(self::LINE_ENDING))) return $data;
		$apart = str_split($data, 72);
		return implode(self::LINE_ENDING . " ", $apart);
	
	}
	/**
	 * Unfold "folded" text
	 */
	protected function unfold($data) {
	
		
	
	}

}