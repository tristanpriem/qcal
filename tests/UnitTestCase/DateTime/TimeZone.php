<?php

class UnitTestCase_DateTime_TimeZone extends \UnitTestCase_DateTime {

    public function testNewTZDefaults2ServerTZ() {
    
        $tz = new qCal\DateTime\TimeZone();
        $this->assertEqual($tz->toString(), $this->_testServerTZ);
    
    }
    
    public function testTZToString() {
    
        $tz = new qCal\DateTime\TimeZone('America/Los_Angeles');
        $this->assertEqual($tz->toString('e'), 'America/Los_Angeles');
        $this->assertEqual($tz->toString('O'), '-0800');
        $this->assertEqual($tz->toString('P'), '-08:00');
        $this->assertEqual($tz->toString('T'), 'PST');
        $this->assertEqual($tz->toString('Z'), '-28800');
    
    }
    
    public function testTzToStringEscapesProperly() {
    
        $chars = 'a|m|M|s|O|\O|P|\P|Z';
        $tz = new qCal\DateTime\TimeZone('America/Los_Angeles');
        $formatted = $tz->toString($chars);
        $this->assertEqual($formatted, 'a|m|M|s|-0800|O|-08:00|P|-28800');
    
    }
    
    public function testNewTZArgOneSetsTZ() {
    
        $tz = new qCal\DateTime\TimeZone('America/New_York');
        $this->assertEqual($tz->toString(), 'America/New_York');
    
    }
    
    public function testSetTZAfterInstantiation() {
    
        $tz = new qCal\DateTime\TimeZone();
        // still default after instantiation
        $this->assertEqual($tz->toString(), $this->_testServerTZ);
        $tz->set('America/New_York');
        // has changed?
        $this->assertEqual($tz->toString(), 'America/New_York');
    
    }
    
    public function testNewTZDoesntAcceptInvalidTZ() {
    
        $zone = 'NotACountry/NotATimezone';
        $this->expectException(new InvalidArgumentException("Timezone ($zone) is not a valid timezone"));
        $tz = new qCal\DateTime\TimeZone($zone);
    
    }
    
    public function testSetTZDoesntAcceptInvalidTZ() {
    
        $zone = 'NotACountry/NotATimezone';
        $tz = new qCal\DateTime\TimeZone();
        $this->expectException(new InvalidArgumentException("Timezone ($zone) is not a valid timezone"));
        $tz->set($zone);
    
    }
    
    /**
     * These fail and I'm not sure I want them to work anyway
    public function testNewTZAccepts3CharTZCode() {
    
        $zone = 'PST';
        $tz = new qCal\DateTime\TimeZone($zone);
        $this->assertEqual($tz->toString('T'), $zone);
    
    }
    
    public function testSetTZAccepts3CharTZCode() {
    
        $zone = 'PST';
        $tz = new qCal\DateTime\TimeZone();
        $tz->set($zone);
        $this->assertEqual($tz->toString('T'), $zone);
    
    }
    **/
    
    /**
     * Need to find a way to do the conversion...
     * Maybe something like qCal\DateTime\TimeZone::fromOffset() or something
     * 
    public function testNewTZAcceptsOffset() {
    
        // @todo I need access to the PHP manual for this one...
        $zone = '+01:00';
        $tz = new qCal\DateTime\TimeZone($zone);
        $this->assertEqual($tz->toString(), $zone);
    
    }
     */
    
    /**
     * @todo I'm not sure if this is right. Right now I have it returning the
     * offset FROM GMT rather than TO it. It may need to be the other way around
     */
    public function testGetTZGMTOffset() {
    
        $tz = new qCal\DateTime\TimeZone();
        $this->assertEqual(date('Z') * -1, $tz->getGmtOffset());
        $moscow = 'Europe/Moscow';
        $tz->set($moscow);
        date_default_timezone_set($moscow);
        $this->assertEqual(date('Z') * -1, $tz->getGmtOffset());
    
    }
    
    public function testUTCWorks() {
    
        $tz = new qCal\DateTime\TimeZone('UTC');
        $this->assertEqual($tz->toString(), 'UTC');
        // @todo This may not always be true, make sure this is right...
        // What is the diff between UTC and GMT
        $this->assertEqual($tz->getGmtOffset(), 0);
    
    }
    
    public function testToStringOverload() {
    
        $tz = new qCal\DateTime\TimeZone('America/Denver');
        $this->assertEqual($tz->__toString(), 'America/Denver');
        $tz->setFormat('O');
        $this->assertEqual($tz->__toString(), '-0700');
    
    }

}