<?php

class UnitTestCase_DateTime_Date extends \UnitTestCase_DateTime {

    public function testNewDateObjectDefaultsToCurrentDate() {
    
        $date = new qCal\DateTime\Date;
        $this->assertEqual($date->toString('m-d-Y'), date('m-d-Y'));
    
    }
    
    public function testNewDateObjectAcceptsDate() {
    
        $year = 2000;
        $month = 4;
        $day = 23;
        $date = new qCal\DateTime\Date($year, $month, $day);
        $this->assertEqual($date->toString('Y-n-d'), date("{$year}-{$month}-{$day}"));
    
    }
    
    public function testNewDateObjectThrowsExceptionSomeButNotAllArgs() {
    
        $this->expectException(new BadMethodCallException("New date expects year, month, and day. Either all must be null or none."));
        $date = new qCal\DateTime\Date(2005);
    
    }
    
    public function testNewDateThrowsExceptionOnInvalidArgs() {
    
        
    
    }
    
    public function testNewDateChecksIfDateIsValid() {
    
        $this->expectException(new InvalidArgumentException('2012-01-55 is not a valid date.'));
        $date = new qCal\DateTime\Date(2012, 1, 55);
    
    }
    
    public function testNewDateAllowsRolloverIfAskedTo() {
    
        $date = new qCal\DateTime\Date(2012, 1, 55, true);
        $this->assertEqual($date->toString('Ymd'), '20120224');
    
    }
    
    public function testCreateFromUnixTimestamp() {
    
        $ts = mktime(0, 0, 0, 4, 23, 2012);
        $date = qCal\DateTime\Date::fromUnixTimestamp($ts);
        $this->assertEqual($date->toString('Y-m-d'), '2012-04-23');
    
    }
    
    public function testCreateFromString() {
    
        $string = '2004-04-23';
        $date = qCal\DateTime\Date::fromString($string);
        $this->assertEqual($date->toString('Y-m-d'), $string);
    
    }
    
    public function testOnlyDateRelevantFormatLettersGetConverted() {
    
        $allLetters =       '|d|D|j|l|N|S|w|z|W|F|m|M|n|t|L|o|Y|y|a|A|B|g|G|h|H|i|s|e|I|O|P|T|Z|c|r|U|';
        $convertedLetters = '|30|Mon|30|Monday|1|th|1|29|05|January|01|Jan|1|31|1|2012|2012|12|a|A|B|g|G|h|H|i|s|e|I|O|P|T|Z|c|r|U|';
        $date = new qCal\DateTime\Date(2012, 1, 30);
        $this->assertEqual($date->toString($allLetters), $convertedLetters);
    
    }
    
    public function testFormatLettersCanBeEscapedWithBackslash() {
    
        $allLetters =       '|d|D|\j|l|N|S|w|\z|W|F|m|M|n|t|L|o|\Y|y|a|A|B|g|G|h|H|i|s|e|I|O|P|T|Z|c|r|U|';
        $convertedLetters = '|30|Mon|j|Monday|1|th|1|z|05|January|01|Jan|1|31|1|2012|Y|12|a|A|B|g|G|h|H|i|s|e|I|O|P|T|Z|c|r|U|';
        $date = new qCal\DateTime\Date(2012, 1, 30);
        $this->assertEqual($date->toString($allLetters), $convertedLetters);
    
    }
    
    public function testFormatEscapingBackslashesWorks() {
    
        $allLetters =       '|d|D|\j|l|N|S|w|\z|W|F|m|M|n|t|L|o|\Y|y|a|A|B|g|G|h|H|i|s|e|I|O|P|T|Z|c|r|U|\\\\';
        $convertedLetters = '|30|Mon|j|Monday|1|th|1|z|05|January|01|Jan|1|31|1|2012|Y|12|a|A|B|g|G|h|H|i|s|e|I|O|P|T|Z|c|r|U|\\';
        $date = new qCal\DateTime\Date(2012, 1, 30);
        $this->assertEqual($date->toString($allLetters), $convertedLetters);
    
    }
    
    public function testFormatEscapingNonDateLettersWorks() {
    
        $allLetters =       '|d|D|\j|l|N|S|w|\z|W|F|m|M|n|t|L|o|\Y|y|a|A|B|g|G|h|H|i|\s|e|\I|O|P|\T|Z|c|r|U|';
        $convertedLetters = '|30|Mon|j|Monday|1|th|1|z|05|January|01|Jan|1|31|1|2012|Y|12|a|A|B|g|G|h|H|i|s|e|I|O|P|T|Z|c|r|U|';
        $date = new qCal\DateTime\Date(2012, 1, 30);
        $this->assertEqual($date->toString($allLetters), $convertedLetters);
    
    }
    
    public function testDateGettersAndSetters() {
    
        $date = new qCal\DateTime\Date(2004, 4, 23);
        $this->assertEqual($date->getYear(), 2004);
        $this->assertEqual($date->getMonth(), 4);
        $this->assertEqual($date->getDay(), 23);
        $date->setYear(2006);
        $date->setMonth(6);
        $this->assertEqual($date->toString('Y-m-d'), '2006-06-23');
    
    }
    
    public function testAddToDate() {
    
        $date = new qCal\DateTime\Date(2010, 4, 23); // worst. day. ever.
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
    
        $date = new qCal\DateTime\Date(2001, 9, 11);
        $this->expectException(new InvalidArgumentException('"baby food" cannot be added to a date.'));
        $date->add('baby food');
    
    }
    
    public function testSubtractFromDate() {
    
        $date = new qCal\DateTime\Date(2010, 4, 23); // worst. day. ever.
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
    
        $date = new qCal\DateTime\Date(2001, 9, 11);
        $this->expectException(new InvalidArgumentException('"baby food" cannot be subtracted from a date.'));
        $date->subtract('baby food');
    
    }
    
    public function testDateIsToday() {
    
        $date = new qCal\DateTime\Date;
        $this->assertTrue($date->isToday());
        $date = new qCal\DateTime\Date(2012, 1, 31);
        $this->assertFalse($date->isToday());
    
    }
    
    public function testDateIsYesterday() {
    
        $date = new qCal\DateTime\Date;
        $this->assertFalse($date->isYesterday());
        $ts = strtotime('yesterday');
        $dp = getdate($ts);
        $date = new qCal\DateTime\Date($dp['year'], $dp['mon'], $dp['mday']);
        $this->assertTrue($date->isYesterday());
    
    }
    
    public function testDateIsTomorrow() {
    
        $date = new qCal\DateTime\Date;
        $this->assertFalse($date->isTomorrow());
        $ts = strtotime('tomorrow');
        $dp = getdate($ts);
        $date = new qCal\DateTime\Date($dp['year'], $dp['mon'], $dp['mday']);
        $this->assertTrue($date->isTomorrow());
    
    }
    
    public function testDateIsBefore() {
    
        $date = new qCal\DateTime\Date(2012, 1, 1);
        $after = new qCal\DateTime\Date(2012, 1, 2);
        $this->assertTrue($date->isBefore($after));
        $this->assertFalse($after->isBefore($date));
    
    }
    
    public function testDateIsAfter() {
    
        $date = new qCal\DateTime\Date(2012, 1, 2);
        $before = new qCal\DateTime\Date(2012, 1, 1);
        $this->assertFalse($before->isAfter($date));
        $this->assertTrue($date->isAfter($before));
    
    }
    
    public function testDateIsEqualTo() {
    
        $before = new qCal\DateTime\Date(2012, 1, 1);
        $same = clone $before;
        $after = new qCal\DateTime\Date(2012, 1, 2);
        $this->assertTrue($before->isEqualTo($same));
        $this->assertFalse($before->isEqualTo($after));
    
    }
    
    /**
     * @todo Once I have a way of representing years < 1900 and > 2038 revisit this
     */
    public function testDateIsLeapYear() {
    
        $date = new qCal\DateTime\Date(2001, 1, 1);
        $this->assertFalse($date->isLeapYear());
        $date->setYear(2000);
        $this->assertTrue($date->isLeapYear());
        $date->setYear(1900);
        $this->assertFalse($date->isLeapYear());
        $date->setYear(2012);
        $this->assertTrue($date->isLeapYear());
    
    }
    
    public function testDateDefaultFormat() {
    
        $date = new qCal\DateTime\Date(2001, 9, 1);
        $this->assertEqual($date->toString(), '2001-09-01');
        $date->setFormat('l F jS, Y');
        $this->assertEqual($date->toString(), 'Saturday September 1st, 2001');
    
    }
    
    public function testToStringOverload() {
    
        $date = new qCal\DateTime\Date(2001, 9, 1);
        $this->assertEqual($date->__toString(), '2001-09-01');
        $date->setFormat('l F jS, Y');
        $this->assertEqual($date->__toString(), 'Saturday September 1st, 2001');
    
    }
    
    // convernience methods
    
    public function testGetNumDaysInYear() {
    
        $date = new qCal\DateTime\Date(2004, 1, 1);
        $this->assertEqual($date->getNumDaysInYear(), 366);
        $date->setYear(2001);
        $this->assertEqual($date->getNumDaysInYear(), 365);
    
    }
    
    public function testGetYearDay() {
    
        $date = new qCal\DateTime\Date(2011, 1, 25);
        $this->assertEqual($date->getYearDay(), 24);
        $date = new qCal\DateTime\Date(2011, 12, 25);
        $this->assertEqual($date->getYearDay(), 358);
        $date = new qCal\DateTime\Date(2012, 12, 25);
        $this->assertEqual($date->getYearDay(), 359);
    
    }
    
    public function testGetNumDaysUntilEndOfYear() {
    
        $date = new qCal\DateTime\Date(2004, 12, 25);
        $this->assertEqual($date->getNumDaysUntilEndOfYear(), 6);
        $date = new qCal\DateTime\Date(2004, 1, 25);
        $this->assertEqual($date->getNumDaysUntilEndOfYear(), 341);
    
    }
    
    public function testGetNumMonthsUntilEndOfYear() {
    
        $date = new qCal\DateTime\Date(2012, 1, 1);
        $this->assertEqual($date->getNumMonthsUntilEndOfYear(), 11);
        $date = new qCal\DateTime\Date(2012, 6, 1);
        $this->assertEqual($date->getNumMonthsUntilEndOfYear(), 6);
    
    }
    
    public function testGetNumDaysUntilEndOfMonth() {
    
        $date = new qCal\DateTime\Date(2012, 1, 5);
        $this->assertEqual($date->getNumDaysUntilEndOfMonth(), 26);
        $date = new qCal\DateTime\Date(2011, 1, 5);
        $this->assertEqual($date->getNumDaysUntilEndOfMonth(), 26);
        $date = new qCal\DateTime\Date(2012, 2, 5);
        $this->assertEqual($date->getNumDaysUntilEndOfMonth(), 24);
        $date = new qCal\DateTime\Date(2011, 2, 5);
        $this->assertEqual($date->getNumDaysUntilEndOfMonth(), 23);
    
    }
    
    public function testGetWeekDay() {
    
        $date = new qCal\DateTime\Date(2012, 1, 5);
        $this->assertEqual($date->getWeekDay(), 4);
        $date = new qCal\DateTime\Date(2012, 1, 1);
        $this->assertEqual($date->getWeekDay(), 0);
    
    }
    
    public function testGetFirstDayOfMonthObject() {
    
        $date = new qCal\DateTime\Date(2012, 1, 13);
        $first = $date->getFirstDayOfMonth();
        $this->assertEqual($first->toString('Ymd'), '20120101');
    
    }
    
    public function testGetLastDayOfMonthObject() {
    
        $date = new qCal\DateTime\Date(2012, 1, 13);
        $first = $date->getLastDayOfMonth();
        $this->assertEqual($first->toString('Ymd'), '20120131');
    
    }
    
    public function testConvertAbbrDayToNum() {
    
        $this->assertEqual(qCal\DateTime\Date::weekDayToNum('tu'), 2);
        $this->assertEqual(qCal\DateTime\Date::weekDayToNum('SU'), 0);
    
    }
    
    public function testConvertWholeDayToNum() {
    
        $this->assertEqual(qCal\DateTime\Date::weekDayToNum('Tuesday'), 2);
        $this->assertEqual(qCal\DateTime\Date::weekDayToNum('SUNDAY'), 0);
    
    }
    
    public function testWeekDayToNumReturnsNumIfPassedNum() {
    
        $this->assertEqual(qCal\DateTime\Date::weekDayToNum(2), 2);
        $this->assertEqual(qCal\DateTime\Date::weekDayToNum(0), 0);
    
    }
    
    public function testConvertMonthNameToNum() {
    
        $this->assertEqual(qCal\DateTime\Date::monthNameToNum('february'), 2);
        $this->assertEqual(qCal\DateTime\Date::monthNameToNum('December'), 12);
    
    }
    
    public function testMonthNameToNumReturnsNumIfPassedNum() {
    
        $this->assertEqual(qCal\DateTime\Date::monthNameToNum(2), 2);
        $this->assertEqual(qCal\DateTime\Date::monthNameToNum(12), 12);
    
    }
    
    /**
     * This method is really cool... it gets the Xth weekday of a given month
     */
    public function testGetXthWeekDayOfMonth() {
    
        // Get the third thursday in November, 2012
        $thirdThurs = qCal\DateTime\Date::getXthWeekdayOfMonth(3, 4, 11, 2012);
        $this->assertEqual($thirdThurs->toString('Ymd'), '20121115');
        
        // Get the last Sunday of January, 2012
        $lastSun = qCal\DateTime\Date::getXthWeekdayOfMonth(-1, 0, 1, 2012);
        $this->assertEqual($lastSun->toString('Ymd'), '20120129');
    
    }
    
    public function testGetXthWeekDayOfMonthUsingAbbrWeekday() {
    
        // Get the third thursday in November, 2012
        $thirdThurs = qCal\DateTime\Date::getXthWeekdayOfMonth(3, 'TH', 11, 2012);
        $this->assertEqual($thirdThurs->toString('Ymd'), '20121115');
        
        // Get the last Sunday of January, 2012
        $lastSun = qCal\DateTime\Date::getXthWeekdayOfMonth(-1, 'SU', 1, 2012);
        $this->assertEqual($lastSun->toString('Ymd'), '20120129');
    
    }
    
    public function testGetXthWeekDayOfMonthUsingWholeWeekday() {
    
        // Get the third thursday in November, 2012
        $thirdThurs = qCal\DateTime\Date::getXthWeekdayOfMonth(3, 'Thursday', 11, 2012);
        $this->assertEqual($thirdThurs->toString('Ymd'), '20121115');
        
        // Get the last Sunday of January, 2012
        $lastSun = qCal\DateTime\Date::getXthWeekdayOfMonth(-1, 'SUnday', 1, 2012);
        $this->assertEqual($lastSun->toString('Ymd'), '20120129');
    
    }
    
    // @todo Add exception tests for everything you can
    /*public function testGetXthWeekDayThrowsExceptionOnInvalidWeekday() {
    
        $this->expectException(new \InvalidArgumentException('There is no 10th Thursday in January'));
        $tenthThurs = qCal\DateTime\Date::getXthWeekdayOfMonth(10, 'TH', 1, 2012);
    
    }*/
    
    public function testGetXthWeekdayOfYear() {
    
        $tenthMonday = qCal\DateTime\Date::getXthWeekdayOfYear(10, 1, 2012);
        $this->assertEqual($tenthMonday->toString('Ymd'), '20120305');
        
        $lastSunday = qCal\DateTime\Date::getXthWeekdayOfYear(-1, 0, 2011);
        $this->assertEqual($lastSunday->toString('Ymd'), '20111225');
    
    }
    
    public function testGetXthWeekdayOfYearUsingAbbrWeekday() {
    
        $tenthMonday = qCal\DateTime\Date::getXthWeekdayOfYear(10, 'mo', 2012);
        $this->assertEqual($tenthMonday->toString('Ymd'), '20120305');
        
        $lastSunday = qCal\DateTime\Date::getXthWeekdayOfYear(-1, 'SU', 2011);
        $this->assertEqual($lastSunday->toString('Ymd'), '20111225');
    
    }
    
    public function testGetXthWeekdayOfYearUsingWholeWeekday() {
    
        $tenthMonday = qCal\DateTime\Date::getXthWeekdayOfYear(10, 'monday', 2012);
        $this->assertEqual($tenthMonday->toString('Ymd'), '20120305');
        
        $lastSunday = qCal\DateTime\Date::getXthWeekdayOfYear(-1, 'SUNday', 2011);
        $this->assertEqual($lastSunday->toString('Ymd'), '20111225');
    
    }
    
    public function testGetUnixTimestamp() {
    
        $date = new qCal\DateTime\Date(2012, 1, 1);
        $this->assertEqual($date->getUnixTimestamp(), '1325376000');
    
    }
    
    public function testGetNumDaysInMonth() {
    
        $date = new qCal\DateTime\Date(2012, 2, 1);
        $this->assertEqual($date->getNumDaysInMonth(), 29);
        $date = new qCal\DateTime\Date(2012, 1, 1);
        $this->assertEqual($date->getNumDaysInMonth(), 31);
        $date = new qCal\DateTime\Date(2011, 2, 1);
        $this->assertEqual($date->getNumDaysInMonth(), 28);
        $date = new qCal\DateTime\Date(2010, 9, 1);
        $this->assertEqual($date->getNumDaysInMonth(), 30);
    
    }
    
    public function testGetWeekDayName() {
    
        $date = new qCal\DateTime\Date(2012, 2, 12);
        $this->assertEqual($date->getWeekdayName(), 'Sunday');
        $date = new qCal\DateTime\Date(2012, 1, 12);
        $this->assertEqual($date->getWeekdayName(), 'Thursday');
        $date = new qCal\DateTime\Date(2001, 9, 11);
        $this->assertEqual($date->getWeekdayName(), 'Tuesday');
    
    }
    
    /**
     * PHP's date() method starts the week on Monday, so the first week of the
     * year doesn't officially start until the first Monday of the year.
     */
    public function testGetWeekOfYear() {
    
        $date = new qCal\DateTime\Date(2012, 1, 1);
        $this->assertEqual($date->getWeekOfYear(), 52); // 2012 starts on a Sunday
        $date = new qCal\DateTime\Date(2012, 1, 2);
        $this->assertEqual($date->getWeekOfYear(), 1); // 1-2-2012 is a Monday
        
        // same thing happens in 2011
        $date = new qCal\DateTime\Date(2011, 1, 1);
        $this->assertEqual($date->getWeekOfYear(), 52); // 1-1-2011 is a Saturday
        $date = new qCal\DateTime\Date(2011, 1, 2);
        $this->assertEqual($date->getWeekOfYear(), 52); // Still last week of year
        $date = new qCal\DateTime\Date(2011, 1, 3);
        $this->assertEqual($date->getWeekOfYear(), 1); // A monday!!
    
    }
}