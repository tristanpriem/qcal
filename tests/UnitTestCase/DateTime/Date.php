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
    
        $this->expectException(new InvalidArgumentException("New date expects year, month, and day. Either all must be null or none."));
        $date = new qCal\DateTime\Date(2005);
    
    }
    
    public function testNewDateThrowsExceptionOnInvalidArgs() {
    
        
    
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

}