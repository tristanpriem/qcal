<?php
/**
 * Default icalendar parser (others include xcal parser, etc.)
 * @package qCal
 * @copyright Luke Visinoni (luke.visinoni@gmail.com)
 * @author Luke Visinoni (luke.visinoni@gmail.com)
 * @license GNU Lesser General Public License
 */ 
class qCal_Parser_iCal extends qCal_Parser {

	public function doParse($tokens) {
	
		$properties = array();
		foreach ($tokens['properties'] as $propertytoken) {
			$params = array();
			foreach ($propertytoken['params'] as $paramtoken) {
				$params[$paramtoken['param']] = $paramtoken['value'];
			}
			$properties[] = qCal_Property::factory($propertytoken['property'], $propertytoken['value'], $params);
		}
		$component = qCal_Component::factory($tokens['component'], $properties);
		foreach ($tokens['children'] as $child) {
			$childcmpnt = $this->doParse($child);
			$component->attach($childcmpnt);
		}
		return $component;
	
	}

}