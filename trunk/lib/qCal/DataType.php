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
	 * Class Constructor
	 *
	 * @return void
	 **/
	public function __construct() {
	
		// do nothing
	
	}

}