<?php
use qCal\DateTime\DateTime,
    qCal\DateTime\Period,
    qCal\DateTime\Duration;

class UnitTestCase_DateTime_Period extends \UnitTestCase_DateTime {

    public function testInstantiationWithBothDateTimeObjects() {
    
        $start = new DateTime(2012, 1, 1, 0, 0, 0, 'America/Los_Angeles');
        $end = new DateTime(2012, 2, 1, 0, 0, 0, 'America/Los_Angeles');
        $period = new Period($start, $end);
        $this->assertEqual($period->toString(), '20120101T080000Z/20120201T080000Z');
    
    }
    
    public function testInstantiationWithDateTimeAndDuration() {
    
        $start = new DateTime(2012, 1, 1, 0, 0, 0, 'America/Los_Angeles');
        $end = new Duration(array('weeks' => 4));
        $period = new Period($start, $end);
        $this->assertEqual($period->toString(), '20120101T080000Z/P4W');
    
    }
    
    // for now i'm going to just require objects
    /*public function testInstantiationWithBothDateTimeStrings() {
    
        $start = '2012-01-01 12:00am';
        $end = '2012-02-01 12:00am';
        $period = new Period($start, $end);
        $this->assertEqual($period->toString(), '20120101T080000Z/20120201T080000Z');
    
    }*/
    
    /*public function testInstantiationWithDateTimeAndDurationStrings() {
    
        
    
    }*/
    
    public function testInstantiationThrowsExceptionIfInvalidStart() {
    
        $this->expectException(new \InvalidArgumentException('Start date/time must be an instance of DateTime.'));
        $start = '2004-04-23 00:00:00';
        $end = DateTime::fromString('2004-04-23 00:00:01');
        $duration = new Period($start, $end);
    
    }
    
    public function testInstantiationThrowsExceptionIfInvalidEnd() {
    
        $this->expectException(new \InvalidArgumentException('End date/time must be an instance of DateTime or Duration.'));
        $start = DateTime::fromString('2004-04-23 00:00:00');
        $end = '2004-04-23 00:00:01';
        $duration = new Period($start, $end);
    
    }
    
    public function testToStringCanConvertDurationToDateTime() {
    
        $start = new DateTime(2012, 1, 1, 0, 0, 0, 'America/Los_Angeles');
        $end = new Duration(array('weeks' => 4));
        $period = new Period($start, $end);
        $this->assertEqual($period->toString(true), '20120101T080000Z/20120129T080000Z');
    
    }
    
    public function testToStringOverload() {
    
        $start = new DateTime(2012, 1, 1, 0, 0, 0, 'America/Los_Angeles');
        $end = new DateTime(2012, 2, 1, 0, 0, 0, 'America/Los_Angeles');
        $period = new Period($start, $end);
        $this->assertEqual($period->__toString(), '20120101T080000Z/20120201T080000Z');
    
    }

}