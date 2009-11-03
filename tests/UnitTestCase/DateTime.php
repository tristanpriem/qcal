<?php
/**
 * @todo Make sure that qCal_Date objects can be accepted anywhere that accepts a date value
 */
class UnitTestCase_DateTime extends UnitTestCase {

	/**
	 * Test data
	 */
	protected $formats = array(
		'ISO' => '1986-04-23 12:00:00',
		'timestamp' => '514670400',
		'UTC' => '19860423T120000Z',
		'America' => '04-23-1986',
		'Elsewhere' => '23-04-1986',
		'YYYY' => '1986',
		'YYYY-MM' => '1986-04',
		'YYYY-MM-DD' => '1986-04-23',
		'YYYY-MM-DDThh:mmTZD' => '1986-04-23T12:00+01:00',
		'YYYY-MM-DDThh:mm:ssTZD' => '1986-04-23T12:00:00+01:00',
	);
	/**
	 * Default time zone
	 */
	protected $defaulttimezone;
	/**
	 * Set up test environment
	 */
	public function setUp() {
	
		// save default timezone
		$this->defaulttimezone = date_default_timezone_get();
	
	}
	/**
	 * Undo whatever was set up in the previous method
	 */
	public function tearDown() {
	
		// return to default timezone after test (why? I dont know)
		date_default_timezone_set($this->defaulttimezone);
	
	}
	/**
	 * The object should default to the current time
	 */
	public function testDefaultsToNow() {

		// only way I can think to test this
		$before = time();
		$date = new qCal_Date();
		$after = time();
		$this->assertTrue(($before <= $date->time() && $after >= $date->time()));
	
	}
	/**
	 * Test that qCal_Date can accept a UTC
	 */
	public function testUTCDate() {
	
		$date = new qCal_Date('19970101T180000Z');
		$this->assertEqual($date->format(qCal_Date::UTC), '19970101T180000Z');
	
	}
	/**
	 * The object should allow a unix timestamp in the constructor
	 */
	public function testAcceptsUnixTimestamp() {
	
		$date = strtotime("04/23/1988 1:00pm");
		$obj = new qCal_Date($date);
		$this->assertEqual($date, $obj->time());
	
	}
	/**
	 * Make sure the object accepts any format accepted by strtotime
	 */
	public function testAcceptsAnythingThatCanBeParsedWithStrToTime() {
	
		$date = "2003-09-23 12:34:03";
		$obj = new qCal_Date($date);
		$this->assertEqual($obj->time(), strtotime($date));
	
	}
	/**
	 * Format a string with date function
	 */
	public function testFormatString() {
	
		$date = new qCal_Date($this->formats['ISO']);
		$this->assertEqual($date->format('Y-m-d'), '1986-04-23');
	
	}
	/**
	 * In many parts of the world, the date is represented as dd-mm-yyyy. in america, it is mm-dd-yyyy. test that
	 * this is handled properly based on time zone or possibly locale settings
	 */
	public function testLocalFormatDate() {
	/*
		$am = new qCal_Date($this->formats['America']); // this format is ambiguous and will not work
		$el = new qCal_Date($this->formats['Elsewhere']);
	*/
	}
	/**
	 * When strtotime fails to create a date, a qCal_Exception_InvalidDate exception should be thrown
	 */
	public function testExceptionThrownOnFailedInit() {
	
		$this->expectException(new qCal_Date_Exception_InvalidDate("Invalid or ambiguous date string passed to qCal_Date::setDate()"));
		$am = new qCal_Date($this->formats['America']); // this format is ambiguous and will not work
	
	}
	/**
	 * If there isn't a timezone specified when creating a date, use the system default
	 */
	public function testServerTimezoneUsedIfNotSpecified() {
	
		$date = new qCal_Date('June 15 2009');
		$this->assertEqual($date->getTimeZone()->getName(), date_default_timezone_get());
		date_default_timezone_set('Europe/London');
		// and after we've set it to something else...
		$date2 = new qCal_Date('June 15 2009');
		$this->assertEqual($date2->getTimeZone()->getName(), 'Europe/London');
	
	}
	/**
	 * Date should be able to be changed in the date object
	 */
	public function testDateCanBeChangedAfterInitialization() {
	
		$date = new qCal_Date('2008-12-22');
		$this->assertEqual($date->format('Y-m-d'), '2008-12-22');
		$date->setByString('2009-01-10');
		$this->assertEqual($date->format('Y-m-d'), '2009-01-10');
	
	}
	/**
	 * Test really old date
	 * @todo eventually id like to make this support old dates like below, but for now, I'm fine with being bound by PHP's date limitations
	 */
	public function XXXtestOldDate() {
	
		$old = new qCal_Date('1810-01-14T05:34:51');
	
	}
	/**
	 * Test that a date can be passed in as a constructor to a new date
	 */
	public function testDateCopy() {
	
		$date1 = new qCal_Date('now');
		$date2 = new qCal_Date($date1);
		$this->assertTrue($date1->format('Ymdhis'), $date2->format('Ymdhis'));
	
	}
	/**
	 * I need to be able to subtract one date from another so I can do time periods in qCal
	 * 
	 * If PHP had real overloading, this could be so bitchin'
	 */
	public function testDateDiff() {
	
		$date1 = new qCal_Date('2009-01-01');
		$date2 = new qCal_Date('2009-01-11'); // ten days
		$span = new qCal_Date_Period($date1, $date2);
		$this->assertEqual($span->seconds(), 864000);
	
	}
	/**
	 * I need to be able to subtract one date from another so I can do time periods in qCal
	 * 
	 * If PHP had real overloading, this could be so bitchin'
	 */
	public function testInvalidDateDiff() {
	
		$date1 = new qCal_Date('2009-01-11');
		$date2 = new qCal_Date('2009-01-01'); // -ten days
		$this->expectException(new qCal_Date_Exception_InvalidPeriod("The start date must come before the end date."));
		$span = new qCal_Date_Period($date1, $date2);
	
	}
	/**
	 * A date duration is a lot like a date period, only not tied to any specific period of time. It represents the amount of time, 
	 * rather than the time itself
	 */
	public function testDateDuration() {
	
		$duration = new qCal_Date_Duration('P14D');
		$this->assertEqual($duration->__toString(), 'P2W');
		// it accepts an amount of seconds
		$duration = new qCal_Date_Duration(474350);
		$this->assertEqual($duration->__toString(), 'P5DT11H45M50S');
		$this->assertEqual($duration->seconds(), 474350);
	
	}
	/**
	 * Test that date can be converted to gmt, utc, and other formats
	 */
	public function testVariousDateFormats() {
	
		$date = new qCal_Date($this->formats['UTC']);
		$this->assertEqual($date->getUtc(), '19860423T120000Z');
	
	}
	/**
	 * Test that when daylight savings is in effect, the object knows how to handle it
	 * @todo Figure out how to test this...
	 */
	public function ZZZtestDaylightSavings() {
	
		$startdate = new qCal_Date("November 1st, 2009 12:00am");
		$enddate = clone $startdate;
		$enddate->modify("+24 hours");
		// I am really not sure this is how this should work :(
		$this->assertEqual($enddate, new qCal_Date("November 1st, 2009 11pm"));
	
	}

}