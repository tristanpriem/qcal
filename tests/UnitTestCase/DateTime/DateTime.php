<?php

class UnitTestCase_DateTime_DateTime extends \UnitTestCase_DateTime {

    public function testDateTimeDefaultsToNow() {
    
        $dt = new qCal\DateTime\DateTime();
        $this->assertEqual($dt->toString('m-d-Y H:i:s'), date('m-d-Y H:i:s'));
    
    }
    
    public function testDateTimeAcceptsDTArgs() {
    
        $dt = new qCal\DateTime\DateTime(2004, 4, 23, 1, 30, 0);
        $this->assertEqual($dt->toString('m-d-Y H:i:s'), '04-23-2004 01:30:00');
    
    }
    
    public function testDateTimeAcceptsTimezone() {
    
        $tz = new qCal\DateTime\TimeZone('GMT');
        $dt = new qCal\DateTime\DateTime(2004, 4, 23, 12, 30, 0, $tz);
        $this->assertEqual($dt->toString('m-d-Y H:i:s'), '04-23-2004 12:30:00');
        $this->assertEqual($dt->toString('m-d-Y H:i:s', new qCal\DateTime\TimeZone('America/Los_Angeles')), '04-23-2004 04:30:00');
    
    }
    
    public function testFromString() {
    
        $dt = qCal\DateTime\DateTime::fromString('2004-04-23T05:30:00', 'America/Denver');
        $this->assertEqual($dt->toString(), '2004-04-23T05:30:00-07:00');
    
    }
    
    public function testDateTimeCanRevertTheDateWhenNecessaryForTimeZoneAdjustment() {
    
        $tz = new qCal\DateTime\TimeZone('GMT');
        $dt = new qCal\DateTime\DateTime(2004, 4, 23, 2, 30, 0, $tz);
        $this->assertEqual($dt->toString('m-d-Y H:i:s'), '04-23-2004 02:30:00');
        $this->assertEqual($dt->toString('m-d-Y H:i:s', new qCal\DateTime\TimeZone('America/Los_Angeles')), '04-22-2004 18:30:00');
    
    }
    
    public function testDateTimeGettersAndSetters() {
    
        $dt = new qCal\DateTime\DateTime();
        $this->assertIsA($dt->getDate(), 'qCal\DateTime\\Date');
        $this->assertIsA($dt->getTime(), 'qCal\DateTime\\Time');
        $this->assertIsA($dt->getTimeZone(), 'qCal\DateTime\\TimeZone');
    
    }
    
    public function testDateTimeIsDaylightSavings() {
    
        $tz = new qCal\DateTime\TimeZone('America/Los_Angeles');
        $dt = new qCal\DateTime\DateTime(2007, 1, 1, 0, 0, 0, $tz);
        $this->assertFalse($dt->isDaylightSavings());
        $dt->getDate()->setMonth(7);
        $this->assertTrue($dt->isDaylightSavings());
    
    }
    
    public function testDateTimeIsDLSavingsEdgeCases() {
    
        $tz = new qCal\DateTime\TimeZone('America/Los_Angeles');
        // starting DL savings edge case
        $dt = new qCal\DateTime\DateTime(2012, 3, 11, 2, 0, 0, $tz); // dl savings starts here
        $this->assertTrue($dt->isDaylightSavings());
        $dt->getTime()->setHour(1)
                      ->setMinute(59)
                      ->setSecond(59); // 1:59:59am is BEFORE dl savings
        $this->assertFalse($dt->isDaylightSavings());
        // ending DL savings edge case
        $dt = new qCal\DateTime\DateTime(2012, 11, 4, 2, 0, 0, $tz); // dl savings ends here
        $this->assertFalse($dt->isDaylightSavings());
        $dt->getTime()->setHour(1)
                      ->setMinute(59)
                      ->setSecond(59); // 1:59:59am is BEFORE dl savings ends
        $this->assertTrue($dt->isDaylightSavings());
    
    }
    
    public function testAllDateTimeFormatLettersGetConverted() {
    
        $allLetters =       '|d|D|j|l|N|S|w|z|W|F|m|M|n|t|L|o|Y|y|a|A|B|g|G|h|H|i|s|e|I|O|P|T|Z|c|r|U|';
        $convertedLetters = '|30|Mon|30|Monday|1|th|1|29|05|January|01|Jan|1|31|1|2012|2012|12|pm|PM|670|3|15|03|15|05|33|America/Los_Angeles|0|-0800|-08:00|PST|-28800|2012-01-30T15:05:33-08:00|Mon, 30 Jan 2012 15:05:33 -0800|U|';
        $dt = new qCal\DateTime\DateTime(2012, 1, 30, 15, 5, 33, 'America/Los_Angeles');
        $this->assertEqual($dt->toString($allLetters), $convertedLetters);
    
    }
    
    public function testSetTimeZoneAsString() {
    
        $dt = new qCal\DateTime\DateTime(2001, 9, 11, 4, 30, 23, 'America/Denver');
        $this->assertEqual($dt->getTimeZone()->toString(), 'America/Denver');
    
    }
    
    public function testDefaultFormat() {
    
        $dt = new qCal\DateTime\DateTime(2001, 9, 11, 4, 30, 23, new qCal\DateTime\Timezone('America/Denver'));
        $this->assertEqual($dt->toString(), '2001-09-11T04:30:23-07:00');
        $dt->setFormat('r');
        $this->assertEqual($dt->toString(), 'Tue, 11 Sep 2001 04:30:23 -0700');
    
    }

}