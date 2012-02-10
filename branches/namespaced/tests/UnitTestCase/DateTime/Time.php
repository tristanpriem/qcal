<?php

class UnitTestCase_DateTime_Time extends \UnitTestCase_DateTime {


    public function testNewTimeObjectDefaultsToCurrentTime() {
    
        $time = new qCal\DateTime\Time();
        $this->assertEqual($time->toString('g:ia'), date('g:ia'));
    
    }
    
    public function testNewTimeObjectSetTime() {
    
        $time = new qCal\DateTime\Time(5, 30, 20);
        $this->assertEqual($time->toString('H:i:s'), '05:30:20');
    
    }
    /*
    public function testNewTimeObjectThrowsExceptionSomeButNotAllArgs() {
    
        $this->expectException(new InvalidArgumentException("New time expects hour and minute."));
        $time = new qCal\DateTime\Time(4);
    
    }
    */
    public function testNewTimeObjectMakesUseOfTimeZone() {
    
        $time = new qCal\DateTime\Time(5, 30, 0, new qCal\DateTime\TimeZone('America/Phoenix'));
        $this->assertEqual($time->toString('g:i:s a'), '5:30:00 am');
    
    }
    
    /**
     * This is ALL fucking off.. need to go back and figure out wtf is going on with gmt offset
     */
    public function testTimeToStringCanAcceptTimezone() {
    
        $time = new qCal\DateTime\Time(1, 20, 0, new qCal\DateTime\Timezone('America/Los_Angeles'));
        $this->assertEqual($time->toString('g:i:s a'), '1:20:00 am');
        // asking for time with a different timezone should alter the output
        $hourforward = new qCal\DateTime\TimeZone('America/Phoenix');
        $this->assertEqual($time->toString('g:i:sa', $hourforward), '2:20:00am');
    
    }
    
    public function testTimeToStringCanGoEitherDirection() {
    
        $negtime = new qCal\DateTime\Time(0, 0, 0, new qCal\DateTime\TimeZone('America/Los_Angeles'));
        $postime = new qCal\DateTime\Time(0, 0, 0, new qCal\DateTime\TimeZone('Europe/Berlin'));
        $this->assertEqual($negtime->toString('H:i:s', new qCal\DateTime\TimeZone('UTC')), '08:00:00');
        $this->assertEqual($postime->toString('H:i:s', new qCal\DateTime\TimeZone('GMT')), '23:00:00');
        // now this is the real trick... from one to the other...
        $this->assertEqual($negtime->toString('H:i:s', new qCal\DateTime\TimeZone('Europe/Berlin')), '09:00:00');
        $this->assertEqual($postime->toString('H:i:s', new qCal\DateTime\TimeZone('America/Los_Angeles')), '15:00:00');
    
    }
    
    public function testTimeTZGettersAndSetters() {
    
        $time = new qCal\DateTime\Time;
        $this->assertIsA($time->getTimeZone(), 'qCal\DateTime\\TimeZone');
        $ny = new qCal\DateTime\TimeZone('America/New_York');
        $time->setTimeZone($ny);
        $this->assertIdentical($time->getTimeZone(), $ny);
    
    }
    
    public function testTimeTZSetUsingStringInsteadOfObject() {
    
        $time = new qCal\DateTime\Time(0, 0, 0, 'America/New_York');
        $this->assertEqual($time->getTimeZone()->toString(), 'America/New_York');
        $time->setTimeZone('Europe/Berlin');
        $this->assertEqual($time->getTimeZone()->toString(), 'Europe/Berlin');
        // make sure toString() can accept a string for timezone as well
        $this->assertEqual($time->toString('g:i:s a', 'America/Denver'), '4:00:00 pm');
    
    }
    
    public function testTimeGettersAndSetters() {
    
        $time = new qCal\DateTime\Time(0, 0, 0, 'America/Los_Angeles');
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
        $this->assertEqual($time->toString('H:i:s', new qCal\DateTime\TimeZone('America/New_York')), '08:23:35');
    
    }
    
    public function testTimeSettersDefaultToNowWhenPassedANullValue() {
    
        $time = new qCal\DateTime\Time(0,0,0);
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
    
        $time = new qCal\DateTime\Time;
        $this->assertIsA($time->setHour(), 'qCal\DateTime\\Time');
        $this->assertIsA($time->setMinute(), 'qCal\DateTime\\Time');
        $this->assertIsA($time->setSecond(), 'qCal\DateTime\\Time');
        $this->assertIsA($time->setTimeZone(), 'qCal\DateTime\\Time');
    
    }
    
    public function testTimeIsBeforeEqualOrAfter() {
    
        $midnight = new qCal\DateTime\Time(0, 0, 0); // Midnight
        $morning  = new qCal\DateTime\Time(6, 0, 0); // Morning
        $noon     = new qCal\DateTime\Time(12, 0, 0); // Noon
        $evening  = new qCal\DateTime\Time(18, 0, 0); // Evening
        $min2mid  = new qCal\DateTime\Time(23, 59, 59); // One second til midnight
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
        $othernoon = new qCal\DateTime\Time(12, 0, 0);
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
    
        $here = new qCal\DateTime\Time(0,0,0,new qCal\DateTime\TimeZone('America/Los_Angeles'));
        $this->assertEqual($here->toString('H:i:s', new qCal\DateTime\TimeZone('Europe/Moscow')), '12:00:00'); // this is coming to 11:00:00
        $this->assertEqual($here->toString('H:i:s', new qCal\DateTime\TimeZone('GMT')), '08:00:00');
        $moscow = new qCal\DateTime\Time(0,0,0,new qCal\DateTime\TimeZone('Europe/Moscow'));
        $this->assertEqual($moscow->toString('H:i:s', new qCal\DateTime\TimeZone('America/Los_Angeles')), '12:00:00'); // this is coming to 13:00:00
        $this->assertEqual($moscow->toString('H:i:s', new qCal\DateTime\TimeZone('GMT')), '20:00:00'); // this is coming to 21:00:00
        
        // same issue with Yekaterinburg? Yup!
        $utc = new qCal\DateTime\Time(0,0,0, new qCal\DateTime\TimeZone('UTC'));
        $this->assertEqual($utc->toString('H:i:s', new qCal\DateTime\TimeZone('Asia/Yekaterinburg')), '06:00:00');
        
        // How about Tokyo - works fine!
        $utc = new qCal\DateTime\Time(0,0,0, new qCal\DateTime\TimeZone('UTC'));
        $this->assertEqual($utc->toString('H:i:s', new qCal\DateTime\TimeZone('Asia/Tokyo')), '09:00:00');
        
        // How about Shanghai- works fine!
        $utc = new qCal\DateTime\Time(0,0,0, new qCal\DateTime\TimeZone('UTC'));
        $this->assertEqual($utc->toString('H:i:s', new qCal\DateTime\TimeZone('Asia/Shanghai')), '08:00:00');
    
    }
     */
    
    public function testTimeDoesntAcceptInvalidArgs() {
    
        // @todo Write a test that expects an exception if object is passed invalid arguments
    
    }
    
    // only these letters should get converted: AaBGgHhis
    public function testOnlyTimeRelevantFormatLettersGetConverted() {
    
        $allLetters =       '|d|D|j|l|N|S|w|z|W|F|m|M|n|t|L|o|Y|y|a|A|B|g|G|h|H|i|s|e|I|O|P|T|Z|c|r|U|';
        $convertedLetters = '|d|D|j|l|N|S|w|z|W|F|m|M|n|t|L|o|Y|y|pm|PM|670|3|15|03|15|05|33|e|I|O|P|T|Z|c|r|U|';
        $time = new qCal\DateTime\Time(15, 5, 33);
        $this->assertEqual($time->toString($allLetters), $convertedLetters);
    
    }
    
    public function testTimeFormatLettersCanBeEscapedWithBackslash() {
    
        $allLetters =       '|d|D|j|l|N|S|w|z|W|F|m|M|n|t|L|o|Y|y|a|\A|B|g|G|h|H|i|\s|e|I|O|P|T|Z|c|r|U|\p\s';
        $convertedLetters = '|d|D|j|l|N|S|w|z|W|F|m|M|n|t|L|o|Y|y|pm|A|670|3|15|03|15|05|s|e|I|O|P|T|Z|c|r|U|ps';
        $time = new qCal\DateTime\Time(15, 5, 35);
        $this->assertEqual($time->toString($allLetters), $convertedLetters);
    
    }
    
    public function testTimeFormatEscapingBackslashesWorks() {
    
        $allLetters =       '|d|D|j|l|N|S|w|z|W|F|m|M|n|t|L|o|Y|y|a|A|B|g|G|h|H|i|s|e|I|O|P|T|Z|c|r|U|\\\\';
        $convertedLetters = '|d|D|j|l|N|S|w|z|W|F|m|M|n|t|L|o|Y|y|pm|PM|670|3|15|03|15|05|33|e|I|O|P|T|Z|c|r|U|\\';
        $time = new qCal\DateTime\Time(15, 5, 33);
        $this->assertEqual($time->toString($allLetters), $convertedLetters);
    
    }
    
    public function testTimeFormatEscapingNonTimeLettersWorks() {
    
        $allLetters =       '|d|D|j|\l|N|\S|w|\z|\W|F|m|M|n|t|L|o|Y|y|a|A|B|g|G|h|H|i|s|e|I|O|P|T|Z|c|r|U|';
        $convertedLetters = '|d|D|j|l|N|S|w|z|W|F|m|M|n|t|L|o|Y|y|pm|PM|670|3|15|03|15|05|33|e|I|O|P|T|Z|c|r|U|';
        $time = new qCal\DateTime\Time(15, 5, 33);
        $this->assertEqual($time->toString($allLetters), $convertedLetters);
    
    }
    
    public function testSetFormat() {
    
        $time = new qCal\DateTime\Time(1, 30, 0, 'America/Los_Angeles');
        $this->assertEqual($time->toString(), '01:30:00');
        $time->setFormat('g:ia');
        $this->assertEqual($time->toString(), '1:30am');
    
    }
    
    public function testToStringOverload() {
    
        $time = new qCal\DateTime\Time(1, 30, 0, 'America/Los_Angeles');
        $this->assertEqual($time->__toString(), '01:30:00');
        $time->setFormat('g:ia');
        $this->assertEqual($time->__toString(), '1:30am');
    
    }
    
    /*public function testTimeFormatsTimeZoneChars() {
    
        $time = new qCal\DateTime\Time(15, 4, 2, 'America/Los_Angeles');
        $this->assertEqual($time->toString('g:ia O'), '3:04pm -0800');
    
    }*/

}