<?php
/**
 * I think eventually I'll add tests like this for all value types
 */
class UnitTestCase_Value_Date extends UnitTestCase {

	/**
	 * If the property permits, multiple "date" values are
	 * specified as a COMMA character (US-ASCII decimal 44) separated list
	 * of values. 
	 */
	public function testMultipleDateValuesSeparatedByCommaChar() {
	
		
	
	}
	/**
     * The format for the value type is expressed as the [ISO
	 * 8601] complete representation, basic format for a calendar date. The
	 * textual format specifies a four-digit year, two-digit month, and
	 * two-digit day of the month. There are no separator characters between
	 * the year, month and day component text.
	 */
	public function testFormatsToISO8601() {
	
		$date = new qCal_Value_Date('Jan 15 2009');
		$this->assertEqual($date->__toString(), '20090115');
	
	}

}