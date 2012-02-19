<?php

use qCal\Recurrence\Pattern\ByDay,
    qCal\Recurrence\Pattern\ByHour,
    qCal\Recurrence\Pattern\ByMinute,
    qCal\Recurrence\Pattern\ByMonth,
    qCal\Recurrence\Pattern\ByMonthDay,
    qCal\Recurrence\Pattern\BySecond,
    qCal\Recurrence\Pattern\BySetPos,
    qCal\Recurrence\Pattern\ByWeekNo,
    qCal\Recurrence\Pattern\ByYearDay,
    qCal\Recurrence\Yearly,
    qCal\DateTime\DateTime;

class UnitTestCase_Recurrence_Yearly extends UnitTestCase {

    public function setUp() {
    
        
    
    }
    
    public function tearDown() {
    
        
    
    }
    
    public function testInstantiateYearly() {
    
        $yearly = new Yearly(2); // every other year
        // time will be taken from start date/time
        $yearly->setStart(new DateTime(1980, 1, 1, 12, 30, 0, 'America/Los_Angeles')); // @todo This should accept a string
        $yearly->setUntil(new DateTime(2014, 1, 1, 12, 30, 0, 'America/Los_Angeles')); // @todo This should accept a string
        $yearly->addRule(new ByMonth(array(1))); // in january
        $yearly->addRule(new ByDay(array('1MO', '1TU'))); // every first monday and tuesday
        $recurrences = $yearly->getRecurrences(); // get all recurrences from DTSTART to UNTIL
        // @todo test that $recurrences contains the right DateTime objects
    
    }
    
    /*public function testRuleRecurrenceLoop() {
    
        $yearly = new Yearly();
        $yearly->setStart(new DateTime(2008, 1, 1, 8, 0, 0, 'America/Los_Angeles'))
               ->setCount(4)
               ->addRule(new ByMonth(array(1,2,3,4,5,9,10,11,12)))
               ->addRule(new ByDay(array('MO','TU','WE','TH','FR')))
               ->addRule(new ByHour(8))
               ->addRule(new ByMinute(0))
               ->addRule(new BySecond(0));
        $yearly->rewind();
        $this->assertEqual($yearly->current()->toString('Y-m-d H:i:s O'), '2008-01-01 08:00:00 -0800');
        $yearly->next();
        $this->assertEqual($yearly->current()->toString('Y-m-d H:i:s O'), '2008-01-02 08:00:00 -0800');
        $yearly->next();
        $this->assertEqual($yearly->current()->toString('Y-m-d H:i:s O'), '2008-01-03 08:00:00 -0800');
        $yearly->next();
        $this->assertEqual($yearly->current()->toString('Y-m-d H:i:s O'), '2008-01-04 08:00:00 -0800');
        $yearly->next();
        $this->assertEqual($yearly->current()->toString('Y-m-d H:i:s O'), '2008-01-07 08:00:00 -0800');
        $yearly->next();
        $this->assertEqual($yearly->current()->toString('Y-m-d H:i:s O'), '2008-01-08 08:00:00 -0800');
        $yearly->rewind();
        $this->assertEqual($yearly->current()->toString('Y-m-d H:i:s O'), '2008-01-01 08:00:00 -0800');
        $yearly->seek(6);
        $this->assertEqual($yearly->current()->toString('Y-m-d H:i:s O'), '2008-01-09 08:00:00 -0800');
    
    }*/

}