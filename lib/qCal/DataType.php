<?php
/**
 * RFC2445 STATES:
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