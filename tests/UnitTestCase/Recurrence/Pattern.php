<?php

use qCal\Recurrence\Pattern\BySecond;
use qCal\DateTime\DateTime;
use qCal\Recurrence\Secondly;
use qCal\Recurrence\Monthly; /*,
    qCal\Recurrence\Minutely,
    qCal\Recurrence\Hourly,
    qCal\Recurrence\Daily,
    qCal\Recurrence\Weekly,
    qCal\Recurrence\Monthly,
    qCal\Recurrence\Yearly;*/

class UnitTestCase_Recurrence_Pattern extends UnitTestCase {

    /*
    public function testNewRecurrence() {
    
        $start = new DateTime(2004, 1, 1, 0, 0, 0, 'America/Los_Angeles');
        $end = new DateTime(2008, 12, 31, 0, 0, 0, 'America/Los_Angeles');
        $monthly = new Monthly($start, 2); // every other month
        $monthly->addRule(new ByDay(array('1MO', '1TU'))) // on 1st monday and tuesday
                ->addRule(new ByHour(array(1, 5))) // ot 1:00 and 5:00
                ->addRule(new ByMinute(30)) // at 1:30 and 5:30
                ->until($end); // until 12/31/2008
        $this->assertEqual($monthly->count(), 50); // not sure how many instance there'd be, but this is how it should work
        $this->assertEqual($monthly->getInstances('2004/04/23 00:00:00', '2005/04/23 12:00:00'), array());
    
    }
    */
    
    public function testInstantiateRecurrencePatternAndGetInterval() {
    
        $secondly = new Secondly(3);
        $this->assertEqual($secondly->getInterval(), 3);
    
    }
    
    public function testSetIntervalConvertsToInteger() {
    
        $secondly = new Secondly('5');
        $this->assertIdentical($secondly->getInterval(), 5);
    
    }
    
    public function testNullIntervalDefaultsToOne() {
    
        $secondly = new Secondly();
        $this->assertEqual($secondly->getInterval(), 1);
    
    }
    
    public function testInstantiationThrowsExceptionOnInvalidStringAsInterval() {
    
        $this->expectException(new InvalidArgumentException('"three" is not a valid interval.'));
        $secondly = new Secondly('three');
    
    }
    
    public function testInstantiationThrowsExceptionOnNegativeInterval() {
    
        $this->expectException(new InvalidArgumentException('"-5" is not a valid interval.'));
        $secondly = new Secondly(-5);
    
    }
    
    public function testSetGetStartDateTime() {
    
        $secondly = new Secondly(30);
        $secondly->setStart(new DateTime(2012, 2, 18, 0, 0, 0, 'America/Los_Angeles'));
        $this->assertEqual($secondly->getStart()->toString('Ymd\THisO'), '20120218T000000-0800');
    
    }
    
    public function testSetGetUntilDateTime() {
    
        $secondly = new Secondly(30);
        $secondly->setUntil(new DateTime(2012, 2, 18, 0, 0, 0, 'America/Los_Angeles'));
        $this->assertEqual($secondly->getUntil()->toString('Ymd\THisO'), '20120218T000000-0800');
    
    }
    
    public function testSetCount() {
    
        $secondly = new Secondly(30);
        $secondly->setCount(10);
        $this->assertEqual($secondly->getCount(), 10);
    
    }
    
    public function testPatternUntilAndCountAreMutuallyExclusive() {
    
        $monthly = new Monthly();
        $monthly->setCount(10);
        $this->assertEqual($monthly->getCount(), 10);
        $monthly->setUntil(new DateTime(2012, 1, 1, 12, 0, 0, 'America/Los_Angeles'));
        // Setting "UNTIL" removes its "COUNT". 
        $this->assertEqual($monthly->getUntil()->toString('Ymd\THisO'), '20120101T120000-0800');
        $this->assertNull($monthly->getCount());
        $monthly->setCount(10);
        $this->assertEqual($monthly->getCount(), 10);
        $this->assertNull($monthly->getUntil());
    
    }
    
    /**
     * Pattern::getCount() returns the value set by the COUNT rule part. It is
     * explicitly set using Pattern::setCount(). The Pattern::count() method is
     * a little different. The count method is used to implement the "Countable"
     * interface. If there is a DTSTART and an UNTIL then it can return the
     * number of recurrences of the pattern (inclusively) within those dates.
     */
    public function testPatternCountWorksDifferentThanGetCount() {
    
        
    
    }
    
    public function testPatternImplementsCountable() {
    
        $monthly = new Monthly();
        $this->assertEqual($monthly->count(), count($monthly));
    
    }
    
    public function testSetWkSt() {
    
        $monthly = new Monthly();
        $monthly->setWeekStart(0);
        $this->assertIdentical($monthly->getWeekStart(), 0);
        
        $monthly->setWeekStart('TU');
        $this->assertIdentical($monthly->getWeekStart(), 2);
        
        $monthly->setWeekStart('Monday');
        $this->assertIdentical($monthly->getWeekStart(), 1);
    
    }
    
    public function testAddRules() {
    
        $secondly = new Secondly(100);
        $secondly->addRule(new BySecond(30));
    
    }

}