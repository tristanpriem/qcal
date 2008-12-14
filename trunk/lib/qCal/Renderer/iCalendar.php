<?php
class qCal_Renderer_iCalendar extends qCal_Renderer {

	const LINE_ENDING = "\r\n";
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
	
	protected function renderProperty($property) {
	
		$propval = $property->getValue();
		$params = $property->getParams();
		$paramreturn = "";
		foreach ($params as $paramname => $paramval) {
			$paramreturn .= ";" . $paramname . "=" . $paramval;
		}
		return $property->getName() . $paramreturn . ":" . $propval . self::LINE_ENDING;
	
	}

}