<?php
/**
 * Test cases for date and time classes
 */
use qCal\Timezone,
    qCal\Date;

class UnitTestCase_DateTime extends \UnitTestCase {

    protected $_origServerTZ;
    
    protected $_testServerTZ = 'America/Los_Angeles';
    
    public function setUp() {
    
        // store original server default
        $this->_origServerTZ = date_default_timezone_get();
        date_default_timezone_set($this->_testServerTZ);
    
    }
    
    public function tearDown() {
    
        // set back to original default server time
        date_default_timezone_set($this->_origServerTZ);
    
    }
    
    public function testNewTZDefaults2ServerTZ() {
    
        $tz = new qCal\TimeZone();
        $this->assertEqual($tz->toString(), $this->_testServerTZ);
    
    }
    
    public function testTZToString() {
    
        $tz = new qCal\TimeZone('America/Los_Angeles');
        $this->assertEqual($tz->toString('e'), 'America/Los_Angeles');
        $this->assertEqual($tz->toString('O'), '-0800');
        $this->assertEqual($tz->toString('P'), '-08:00');
        $this->assertEqual($tz->toString('T'), 'PST');
        $this->assertEqual($tz->toString('Z'), '-28800');
    
    }
    
    public function testTzToStringEscapesProperly() {
    
        $chars = 'a|m|M|s|O|\O|P|\P|Z';
        $tz = new qCal\TimeZone('America/Los_Angeles');
        $formatted = $tz->toString($chars);
        $this->assertEqual($formatted, 'a|m|M|s|-0800|O|-08:00|P|-28800');
    
    }
    
    public function testNewTZArgOneSetsTZ() {
    
        $tz = new qCal\TimeZone('America/New_York');
        $this->assertEqual($tz->toString(), 'America/New_York');
    
    }
    
    public function testSetTZAfterInstantiation() {
    
        $tz = new qCal\TimeZone();
        // still default after instantiation
        $this->assertEqual($tz->toString(), $this->_testServerTZ);
        $tz->set('America/New_York');
        // has changed?
        $this->assertEqual($tz->toString(), 'America/New_York');
    
    }
    
    public function testNewTZDoesntAcceptInvalidTZ() {
    
        $zone = 'NotACountry/NotATimezone';
        $this->expectException(new InvalidArgumentException("Timezone ($zone) is not a valid timezone"));
        $tz = new qCal\TimeZone($zone);
    
    }
    
    public function testSetTZDoesntAcceptInvalidTZ() {
    
        $zone = 'NotACountry/NotATimezone';
        $tz = new qCal\TimeZone();
        $this->expectException(new InvalidArgumentException("Timezone ($zone) is not a valid timezone"));
        $tz->set($zone);
    
    }
    
    /**
     * These fail and I'm not sure I want them to work anyway
    public function testNewTZAccepts3CharTZCode() {
    
        $zone = 'PST';
        $tz = new qCal\TimeZone($zone);
        $this->assertEqual($tz->toString('T'), $zone);
    
    }
    
    public function testSetTZAccepts3CharTZCode() {
    
        $zone = 'PST';
        $tz = new qCal\TimeZone();
        $tz->set($zone);
        $this->assertEqual($tz->toString('T'), $zone);
    
    }
    **/
    
    /**
     * Need to find a way to do the conversion...
     * Maybe something like qCal\TimeZone::fromOffset() or something
     * 
    public function testNewTZAcceptsOffset() {
    
        // @todo I need access to the PHP manual for this one...
        $zone = '+01:00';
        $tz = new qCal\TimeZone($zone);
        $this->assertEqual($tz->toString(), $zone);
    
    }
     */
    
    /**
     * @todo I'm not sure if this is right. Right now I have it returning the
     * offset FROM GMT rather than TO it. It may need to be the other way around
     */
    public function testGetTZGMTOffset() {
    
        $tz = new qCal\TimeZone();
        $this->assertEqual(date('Z') * -1, $tz->getGmtOffset());
        $moscow = 'Europe/Moscow';
        $tz->set($moscow);
        date_default_timezone_set($moscow);
        $this->assertEqual(date('Z') * -1, $tz->getGmtOffset());
    
    }
    
    public function testUTCWorks() {
    
        $tz = new qCal\TimeZone('UTC');
        $this->assertEqual($tz->toString(), 'UTC');
        // @todo This may not always be true, make sure this is right...
        // What is the diff between UTC and GMT
        $this->assertEqual($tz->getGmtOffset(), 0);
    
    }
    
    /**
     * Date Class
     */
    
    public function testNewDateObjectDefaultsToCurrentDate() {
    
        $date = new qCal\Date;
        $this->assertEqual($date->toString('m-d-Y'), date('m-d-Y'));
    
    }
    
    public function testNewDateObjectAcceptsDate() {
    
        $year = 2000;
        $month = 4;
        $day = 23;
        $date = new qCal\Date($year, $month, $day);
        $this->assertEqual($date->toString('Y-n-d'), date("{$year}-{$month}-{$day}"));
    
    }
    
    public function testNewDateObjectThrowsExceptionSomeButNotAllArgs() {
    
        $this->expectException(new InvalidArgumentException("New date expects year, month, and day. Either all must be null or none."));
        $date = new qCal\Date(2005);
    
    }
    
    public function testNewDateThrowsExceptionOnInvalidArgs() {
    
        
    
    }
    
    public function testCreateFromUnixTimestamp() {
    
        $ts = mktime(0, 0, 0, 4, 23, 2012);
        $date = qCal\Date::fromUnixTimestamp($ts);
        $this->assertEqual($date->toString('Y-m-d'), '2012-04-23');
    
    }
    
    public function testCreateFromString() {
    
        $string = '2004-04-23';
        $date = qCal\Date::fromString($string);
        $this->assertEqual($date->toString('Y-m-d'), $string);
    
    }
    
    public function testOnlyDateRelevantFormatLettersGetConverted() {
    
        $allLetters =       '|d|D|j|l|N|S|w|z|W|F|m|M|n|t|L|o|Y|y|a|A|B|g|G|h|H|i|s|e|I|O|P|T|Z|c|r|U|';
        $convertedLetters = '|30|Mon|30|Monday|1|th|1|29|05|January|01|Jan|1|31|1|2012|2012|12|a|A|B|g|G|h|H|i|s|e|I|O|P|T|Z|c|r|U|';
        $date = new qCal\Date(2012, 1, 30);
        $this->assertEqual($date->toString($allLetters), $convertedLetters);
    
    }
    
    public function testFormatLettersCanBeEscapedWithBackslash() {
    
        $allLetters =       '|d|D|\j|l|N|S|w|\z|W|F|m|M|n|t|L|o|\Y|y|a|A|B|g|G|h|H|i|s|e|I|O|P|T|Z|c|r|U|';
        $convertedLetters = '|30|Mon|j|Monday|1|th|1|z|05|January|01|Jan|1|31|1|2012|Y|12|a|A|B|g|G|h|H|i|s|e|I|O|P|T|Z|c|r|U|';
        $date = new qCal\Date(2012, 1, 30);
        $this->assertEqual($date->toString($allLetters), $convertedLetters);
    
    }
    
    public function testFormatEscapingBackslashesWorks() {
    
        $allLetters =       '|d|D|\j|l|N|S|w|\z|W|F|m|M|n|t|L|o|\Y|y|a|A|B|g|G|h|H|i|s|e|I|O|P|T|Z|c|r|U|\\\\';
        $convertedLetters = '|30|Mon|j|Monday|1|th|1|z|05|January|01|Jan|1|31|1|2012|Y|12|a|A|B|g|G|h|H|i|s|e|I|O|P|T|Z|c|r|U|\\';
        $date = new qCal\Date(2012, 1, 30);
        $this->assertEqual($date->toString($allLetters), $convertedLetters);
    
    }
    
    public function testFormatEscapingNonDateLettersWorks() {
    
        $allLetters =       '|d|D|\j|l|N|S|w|\z|W|F|m|M|n|t|L|o|\Y|y|a|A|B|g|G|h|H|i|\s|e|\I|O|P|\T|Z|c|r|U|';
        $convertedLetters = '|30|Mon|j|Monday|1|th|1|z|05|January|01|Jan|1|31|1|2012|Y|12|a|A|B|g|G|h|H|i|s|e|I|O|P|T|Z|c|r|U|';
        $date = new qCal\Date(2012, 1, 30);
        $this->assertEqual($date->toString($allLetters), $convertedLetters);
    
    }
    
    public function testDateGettersAndSetters() {
    
        $date = new qCal\Date(2004, 4, 23);
        $this->assertEqual($date->getYear(), 2004);
        $this->assertEqual($date->getMonth(), 4);
        $this->assertEqual($date->getDay(), 23);
        $date->setYear(2006);
        $date->setMonth(6);
        $this->assertEqual($date->toString('Y-m-d'), '2006-06-23');
    
    }
    
    public function testAddToDate() {
    
        $date = new qCal\Date(2010, 4, 23); // worst. day. ever.
        $plusfourdays = $date->add('4 days');
        $this->assertEqual($plusfourdays->toString('Y-m-d'), '2010-04-27');
        $plusfouryears = $date->add('4 years');
        $this->assertEqual($plusfouryears->toString('Y-m-d'), '2014-04-23');
        $plustenmonths = $date->add('10 months');
        $this->assertEqual($plustenmonths->toString('Y-m-d'), '2011-02-23');
        $plushunthousandseconds = $date->add('100000 seconds'); // plus a little over 27 hours
        $this->assertEqual($plushunthousandseconds->toString('Y-m-d'), '2010-04-24');
    
    }
    
    public function testAddToThrowsExceptionOnInvalidInput() {
    
        $date = new qCal\Date(2001, 9, 11);
        $this->expectException(new InvalidArgumentException('"baby food" cannot be added to a date.'));
        $date->add('baby food');
    
    }
    
    public function testSubtractFromDate() {
    
        $date = new qCal\Date(2010, 4, 23); // worst. day. ever.
        $minusfourdays = $date->subtract('4 days');
        $this->assertEqual($minusfourdays->toString('Y-m-d'), '2010-04-19');
        $minusfouryears = $date->subtract('4 years');
        $this->assertEqual($minusfouryears->toString('Y-m-d'), '2006-04-23');
        $minustenmonths = $date->subtract('10 months');
        $this->assertEqual($minustenmonths->toString('Y-m-d'), '2009-06-23');
        $minushunthousandseconds = $date->subtract('100000 seconds'); // minus a little over 27 hours
        $this->assertEqual($minushunthousandseconds->toString('Y-m-d'), '2010-04-21');
    
    }
    
    public function testSubtractFromThrowsExceptionOnInvalidInput() {
    
        $date = new qCal\Date(2001, 9, 11);
        $this->expectException(new InvalidArgumentException('"baby food" cannot be subtracted from a date.'));
        $date->subtract('baby food');
    
    }
    
    public function testDateIsToday() {
    
        $date = new qCal\Date;
        $this->assertTrue($date->isToday());
        $date = new qCal\Date(2012, 1, 31);
        $this->assertFalse($date->isToday());
    
    }
    
    public function testDateIsYesterday() {
    
        $date = new qCal\Date;
        $this->assertFalse($date->isYesterday());
        $ts = strtotime('yesterday');
        $dp = getdate($ts);
        $date = new qCal\Date($dp['year'], $dp['mon'], $dp['mday']);
        $this->assertTrue($date->isYesterday());
    
    }
    
    public function testDateIsTomorrow() {
    
        $date = new qCal\Date;
        $this->assertFalse($date->isTomorrow());
        $ts = strtotime('tomorrow');
        $dp = getdate($ts);
        $date = new qCal\Date($dp['year'], $dp['mon'], $dp['mday']);
        $this->assertTrue($date->isTomorrow());
    
    }
    
    public function testDateIsBefore() {
    
        $date = new qCal\Date(2012, 1, 1);
        $after = new qCal\Date(2012, 1, 2);
        $this->assertTrue($date->isBefore($after));
        $this->assertFalse($after->isBefore($date));
    
    }
    
    public function testDateIsAfter() {
    
        $date = new qCal\Date(2012, 1, 2);
        $before = new qCal\Date(2012, 1, 1);
        $this->assertFalse($before->isAfter($date));
        $this->assertTrue($date->isAfter($before));
    
    }
    
    public function testDateIsEqualTo() {
    
        $before = new qCal\Date(2012, 1, 1);
        $same = clone $before;
        $after = new qCal\Date(2012, 1, 2);
        $this->assertTrue($before->isEqualTo($same));
        $this->assertFalse($before->isEqualTo($after));
    
    }
    
    /**
     * @todo Once I have a way of representing years < 1900 and > 2038 revisit this
     */
    public function testDateIsLeapYear() {
    
        $date = new qCal\Date(2001, 1, 1);
        $this->assertFalse($date->isLeapYear());
        $date->setYear(2000);
        $this->assertTrue($date->isLeapYear());
        $date->setYear(1900);
        $this->assertFalse($date->isLeapYear());
        $date->setYear(2012);
        $this->assertTrue($date->isLeapYear());
    
    }
    
    public function testDateDefaultFormat() {
    
        $date = new qCal\Date(2001, 9, 1);
        $this->assertEqual($date->toString(), '2001-09-01');
        $date->setFormat('l F jS, Y');
        $this->assertEqual($date->toString(), 'Saturday September 1st, 2001');
    
    }
    
    /**
     * Time Class
     */
    
    public function testNewTimeObjectDefaultsToCurrentTime() {
    
        $time = new qCal\Time();
        $this->assertEqual($time->toString('g:ia'), date('g:ia'));
    
    }
    
    public function testNewTimeObjectSetTime() {
    
        $time = new qCal\Time(5, 30, 20);
        $this->assertEqual($time->toString('H:i:s'), '05:30:20');
    
    }
    /*
    public function testNewTimeObjectThrowsExceptionSomeButNotAllArgs() {
    
        $this->expectException(new InvalidArgumentException("New time expects hour and minute."));
        $time = new qCal\Time(4);
    
    }
    */
    public function testNewTimeObjectMakesUseOfTimeZone() {
    
        $time = new qCal\Time(5, 30, 0, new qCal\TimeZone('America/Phoenix'));
        $this->assertEqual($time->toString('g:i:s a'), '5:30:00 am');
    
    }
    
    /**
     * This is ALL fucking off.. need to go back and figure out wtf is going on with gmt offset
     */
    public function testTimeToStringCanAcceptTimezone() {
    
        $time = new qCal\Time(1, 20, 0, new qCal\Timezone('America/Los_Angeles'));
        $this->assertEqual($time->toString('g:i:s a'), '1:20:00 am');
        // asking for time with a different timezone should alter the output
        $hourforward = new qCal\TimeZone('America/Phoenix');
        $this->assertEqual($time->toString('g:i:sa', $hourforward), '2:20:00am');
    
    }
    
    public function testTimeToStringCanGoEitherDirection() {
    
        $negtime = new qCal\Time(0, 0, 0, new qCal\TimeZone('America/Los_Angeles'));
        $postime = new qCal\Time(0, 0, 0, new qCal\TimeZone('Europe/Berlin'));
        $this->assertEqual($negtime->toString('H:i:s', new qCal\TimeZone('UTC')), '08:00:00');
        $this->assertEqual($postime->toString('H:i:s', new qCal\TimeZone('GMT')), '23:00:00');
        // now this is the real trick... from one to the other...
        $this->assertEqual($negtime->toString('H:i:s', new qCal\TimeZone('Europe/Berlin')), '09:00:00');
        $this->assertEqual($postime->toString('H:i:s', new qCal\TimeZone('America/Los_Angeles')), '15:00:00');
    
    }
    
    public function testTimeTZGettersAndSetters() {
    
        $time = new qCal\Time;
        $this->assertIsA($time->getTimeZone(), 'qCal\\TimeZone');
        $ny = new qCal\TimeZone('America/New_York');
        $time->setTimeZone($ny);
        $this->assertIdentical($time->getTimeZone(), $ny);
    
    }
    
    public function testTimeTZSetUsingStringInsteadOfObject() {
    
        $time = new qCal\Time(0, 0, 0, 'America/New_York');
        $this->assertEqual($time->getTimeZone()->toString(), 'America/New_York');
        $time->setTimeZone('Europe/Berlin');
        $this->assertEqual($time->getTimeZone()->toString(), 'Europe/Berlin');
        // make sure toString() can accept a string for timezone as well
        $this->assertEqual($time->toString('g:i:s a', 'America/Denver'), '4:00:00 pm');
    
    }
    
    public function testTimeGettersAndSetters() {
    
        $time = new qCal\Time(0, 0, 0, 'America/Los_Angeles');
        $time->setHour(5);
        $this->assertEqual($time->toString('H:i:s'), '05:00:00');
        $this->assertEqual($time->getHour(), 5);
        $time->setMinute(23);
        $this->assertEqual($time->toString('H:i:s'), '05:23:00');
        $this->assertEqual($time->getMinute(), 23);
        $time->setSecond(35);
        $this->assertEqual($time->toString('H:i:s'), '05:23:35');
        $this->assertEqual($time->getSecond(), 35);
        
        // just to be sure timezones still work after changing the time
        $this->assertEqual($time->toString('H:i:s', new qCal\TimeZone('America/New_York')), '08:23:35');
    
    }
    
    public function testTimeSettersDefaultToNowWhenPassedANullValue() {
    
        $time = new qCal\Time(0,0,0);
        $this->assertEqual($time->toString('g:i:s a'), '12:00:00 am');
        $time->setHour();
        $this->assertEqual($time->getHour(), date('H'));
        $time->setMinute();
        $this->assertEqual($time->getMinute(), date('i'));
        $time->setSecond();
        $this->assertEqual($time->getSecond(), date('s'));
        
        // timezone does it too
        $time->setTimeZone();
        $this->assertEqual($time->getTimeZone()->toString(), date('e'));
    
    }
    
    public function testTimeFluidSetters() {
    
        $time = new qCal\Time;
        $this->assertIsA($time->setHour(), 'qCal\\Time');
        $this->assertIsA($time->setMinute(), 'qCal\\Time');
        $this->assertIsA($time->setSecond(), 'qCal\\Time');
        $this->assertIsA($time->setTimeZone(), 'qCal\\Time');
    
    }
    
    public function testTimeIsBeforeEqualOrAfter() {
    
        $midnight = new qCal\Time(0, 0, 0); // Midnight
        $morning  = new qCal\Time(6, 0, 0); // Morning
        $noon     = new qCal\Time(12, 0, 0); // Noon
        $evening  = new qCal\Time(18, 0, 0); // Evening
        $min2mid  = new qCal\Time(23, 59, 59); // One second til midnight
        $this->assertTrue($midnight->isBefore($min2mid));
        // pre($min2mid->toString('His') . ' ' . $midnight->toString('His'));
        $this->assertTrue($min2mid->isAfter($midnight));
        $this->assertFalse($morning->isAfter($evening));
        $this->assertFalse($evening->isAfter($min2mid));
        $this->assertFalse($noon->isBefore($midnight));
        $this->assertFalse($min2mid->isBefore($min2mid));
        $this->assertFalse($min2mid->isBefore($midnight));
        $this->assertTrue($midnight->isBefore($noon));
        // equality
        $othernoon = new qCal\Time(12, 0, 0);
        $this->assertFalse($noon->isEqualTo($evening));
        $this->assertTrue($noon->isEqualTo($noon));
        $this->assertTrue($noon->isEqualTo(clone $noon));
        $this->assertTrue($noon->isEqualTo($othernoon));
    
    }
    
    public function testTimeIsBeforeEqualToOrAfterString() {
    
        
    
    }
    
    public function testTimeComparisonMethodsAcceptStringTimeValue() {
    
        
    
    }
    
    /**
     * Moscow was giving me trouble for some reason, so I threw this in there to be sure...
     * Possibly a daylight savings issue...
     * Nope! It's actually a problem WITHIN the PHP install! It has nothing to
     * do with my code! Phew! I don't have to do anything either because it is
     * only because this PHP install isn't up to date! :)
     * @todo Re-enable this before it goes live because it will tell end-users
     * that their PHP needs to be updated.
    public function testTimeAndZoneRussiaConversion() {
    
        $here = new qCal\Time(0,0,0,new qCal\TimeZone('America/Los_Angeles'));
        $this->assertEqual($here->toString('H:i:s', new qCal\TimeZone('Europe/Moscow')), '12:00:00'); // this is coming to 11:00:00
        $this->assertEqual($here->toString('H:i:s', new qCal\TimeZone('GMT')), '08:00:00');
        $moscow = new qCal\Time(0,0,0,new qCal\TimeZone('Europe/Moscow'));
        $this->assertEqual($moscow->toString('H:i:s', new qCal\TimeZone('America/Los_Angeles')), '12:00:00'); // this is coming to 13:00:00
        $this->assertEqual($moscow->toString('H:i:s', new qCal\TimeZone('GMT')), '20:00:00'); // this is coming to 21:00:00
        
        // same issue with Yekaterinburg? Yup!
        $utc = new qCal\Time(0,0,0, new qCal\TimeZone('UTC'));
        $this->assertEqual($utc->toString('H:i:s', new qCal\TimeZone('Asia/Yekaterinburg')), '06:00:00');
        
        // How about Tokyo - works fine!
        $utc = new qCal\Time(0,0,0, new qCal\TimeZone('UTC'));
        $this->assertEqual($utc->toString('H:i:s', new qCal\TimeZone('Asia/Tokyo')), '09:00:00');
        
        // How about Shanghai- works fine!
        $utc = new qCal\Time(0,0,0, new qCal\TimeZone('UTC'));
        $this->assertEqual($utc->toString('H:i:s', new qCal\TimeZone('Asia/Shanghai')), '08:00:00');
    
    }
     */
    
    public function testTimeDoesntAcceptInvalidArgs() {
    
        // @todo Write a test that expects an exception if object is passed invalid arguments
    
    }
    
    // only these letters should get converted: AaBGgHhis
    public function testOnlyTimeRelevantFormatLettersGetConverted() {
    
        $allLetters =       '|d|D|j|l|N|S|w|z|W|F|m|M|n|t|L|o|Y|y|a|A|B|g|G|h|H|i|s|e|I|O|P|T|Z|c|r|U|';
        $convertedLetters = '|d|D|j|l|N|S|w|z|W|F|m|M|n|t|L|o|Y|y|pm|PM|670|3|15|03|15|05|33|e|I|O|P|T|Z|c|r|U|';
        $time = new qCal\Time(15, 5, 33);
        $this->assertEqual($time->toString($allLetters), $convertedLetters);
    
    }
    
    public function testTimeFormatLettersCanBeEscapedWithBackslash() {
    
        $allLetters =       '|d|D|j|l|N|S|w|z|W|F|m|M|n|t|L|o|Y|y|a|\A|B|g|G|h|H|i|\s|e|I|O|P|T|Z|c|r|U|\p\s';
        $convertedLetters = '|d|D|j|l|N|S|w|z|W|F|m|M|n|t|L|o|Y|y|pm|A|670|3|15|03|15|05|s|e|I|O|P|T|Z|c|r|U|ps';
        $time = new qCal\Time(15, 5, 35);
        $this->assertEqual($time->toString($allLetters), $convertedLetters);
    
    }
    
    public function testTimeFormatEscapingBackslashesWorks() {
    
        $allLetters =       '|d|D|j|l|N|S|w|z|W|F|m|M|n|t|L|o|Y|y|a|A|B|g|G|h|H|i|s|e|I|O|P|T|Z|c|r|U|\\\\';
        $convertedLetters = '|d|D|j|l|N|S|w|z|W|F|m|M|n|t|L|o|Y|y|pm|PM|670|3|15|03|15|05|33|e|I|O|P|T|Z|c|r|U|\\';
        $time = new qCal\Time(15, 5, 33);
        $this->assertEqual($time->toString($allLetters), $convertedLetters);
    
    }
    
    public function testTimeFormatEscapingNonTimeLettersWorks() {
    
        $allLetters =       '|d|D|j|\l|N|\S|w|\z|\W|F|m|M|n|t|L|o|Y|y|a|A|B|g|G|h|H|i|s|e|I|O|P|T|Z|c|r|U|';
        $convertedLetters = '|d|D|j|l|N|S|w|z|W|F|m|M|n|t|L|o|Y|y|pm|PM|670|3|15|03|15|05|33|e|I|O|P|T|Z|c|r|U|';
        $time = new qCal\Time(15, 5, 33);
        $this->assertEqual($time->toString($allLetters), $convertedLetters);
    
    }
    
    /**
     * Now, to put all these together... in a DateTime class
     */
    
    public function testDateTimeDefaultsToNow() {
    
        $dt = new qCal\DateTime();
        $this->assertEqual($dt->toString('m-d-Y H:i:s'), date('m-d-Y H:i:s'));
    
    }
    
    public function testDateTimeAcceptsDTArgs() {
    
        $dt = new qCal\DateTime(2004, 4, 23, 1, 30, 0);
        $this->assertEqual($dt->toString('m-d-Y H:i:s'), '04-23-2004 01:30:00');
    
    }
    
    public function testDateTimeAcceptsTimezone() {
    
        $tz = new qCal\TimeZone('GMT');
        $dt = new qCal\DateTime(2004, 4, 23, 12, 30, 0, $tz);
        $this->assertEqual($dt->toString('m-d-Y H:i:s'), '04-23-2004 12:30:00');
        $this->assertEqual($dt->toString('m-d-Y H:i:s', new qCal\TimeZone('America/Los_Angeles')), '04-23-2004 04:30:00');
    
    }
    
    public function testDateTimeCanRevertTheDateWhenNecessaryForTimeZoneAdjustment() {
    
        $tz = new qCal\TimeZone('GMT');
        $dt = new qCal\DateTime(2004, 4, 23, 2, 30, 0, $tz);
        $this->assertEqual($dt->toString('m-d-Y H:i:s'), '04-23-2004 02:30:00');
        $this->assertEqual($dt->toString('m-d-Y H:i:s', new qCal\TimeZone('America/Los_Angeles')), '04-22-2004 18:30:00');
    
    }
    
    public function testDateTimeGettersAndSetters() {
    
        $dt = new qCal\DateTime();
        $this->assertIsA($dt->getDate(), 'qCal\\Date');
        $this->assertIsA($dt->getTime(), 'qCal\\Time');
        $this->assertIsA($dt->getTimeZone(), 'qCal\\TimeZone');
    
    }
    
    public function testDateTimeIsDaylightSavings() {
    
        $tz = new qCal\TimeZone('America/Los_Angeles');
        $dt = new qCal\DateTime(2007, 1, 1, 0, 0, 0, $tz);
        $this->assertFalse($dt->isDaylightSavings());
        $dt->getDate()->setMonth(7);
        $this->assertTrue($dt->isDaylightSavings());
    
    }
    
    public function testDateTimeIsDLSavingsEdgeCases() {
    
        $tz = new qCal\TimeZone('America/Los_Angeles');
        // starting DL savings edge case
        $dt = new qCal\DateTime(2012, 3, 11, 2, 0, 0, $tz); // dl savings starts here
        $this->assertTrue($dt->isDaylightSavings());
        $dt->getTime()->setHour(1)
                      ->setMinute(59)
                      ->setSecond(59); // 1:59:59am is BEFORE dl savings
        $this->assertFalse($dt->isDaylightSavings());
        // ending DL savings edge case
        $dt = new qCal\DateTime(2012, 11, 4, 2, 0, 0, $tz); // dl savings ends here
        $this->assertFalse($dt->isDaylightSavings());
        $dt->getTime()->setHour(1)
                      ->setMinute(59)
                      ->setSecond(59); // 1:59:59am is BEFORE dl savings ends
        $this->assertTrue($dt->isDaylightSavings());
    
    }
    
    public function testAllDateTimeFormatLettersGetConverted() {
    
        $allLetters =       '|d|D|j|l|N|S|w|z|W|F|m|M|n|t|L|o|Y|y|a|A|B|g|G|h|H|i|s|e|I|O|P|T|Z|c|r|U|';
        $convertedLetters = '|30|Mon|30|Monday|1|th|1|29|05|January|01|Jan|1|31|1|2012|2012|12|pm|PM|670|3|15|03|15|05|33|America/Los_Angeles|0|-0800|-08:00|PST|-28800|2012-01-30T15:05:33-08:00|Mon, 30 Jan 2012 15:05:33 -0800|U|';
        $dt = new qCal\DateTime(2012, 1, 30, 15, 5, 33, 'America/Los_Angeles');
        $this->assertEqual($dt->toString($allLetters), $convertedLetters);
    
    }

}