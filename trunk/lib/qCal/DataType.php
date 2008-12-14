<?php
/**
 * Base property data type class. Every property value has a specific data
 * type. Some of them are very simple, such as boolean. Others can be
 * rather complex, such as rrule (specifies a date pattern for recurring
 * events and other components).
 * @package qCal
 * @copyright Luke Visinoni (luke.visinoni@gmail.com)
 * @author Luke Visinoni (luke.visinoni@gmail.com)
 * @license GNU Lesser General Public License
 * 
 * RFC 2445 Definition
 * 
 * The properties in an iCalendar object are strongly typed. The
 * definition of each property restricts the value to be one of the
 * value data types, or simply value types, defined in this section. The
 * value type for a property will either be specified implicitly as the
 * default value type or will be explicitly specified with the "VALUE"
 * parameter. If the value type of a property is one of the alternate
 * valid types, then it MUST be explicitly specified with the "VALUE"
 * parameter.
 * 
 * qCal_DateType Class
 * Calendar properties can be any of several property types. All property
 * types extend this abstract class. 
 */
abstract class qCal_DataType {

	/**
	 * A factory for data type objects. Pass in a type and a value, and it will return the value
	 * casted to the proper type
	 */
	public static function factory($type, $value) {

		// remove dashes, capitalize properly
		$parts = explode("-", $type);
		$type = "";
		foreach ($parts as $part) $type .= trim(ucfirst(strtolower($part)));
		// get the class, and instantiate
		$className = "qCal_DataType_" . $type;
		$class = new $className;
		return $class->cast($value);
	
	}
	/**
	 * Casts $value to this data type (usually from a string)
	 */
	public function cast($value) {
	
		return $this->doCast($value);
	
	}
	/**
	 * This is left to be implemented by children classes, basically they 
	 * implement this method to cast any input into their data type
	 */
	abstract protected function doCast($value);

}