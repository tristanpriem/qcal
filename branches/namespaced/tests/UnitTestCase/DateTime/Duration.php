<?php

class UnitTestCase_DateTime_Duration extends \UnitTestCase_DateTime {

    public function testInstantiationAndNormalization() {
    
        $duration = new qCal\DateTime\Duration(array('weeks' => '3', 'days' => 0, 'minutes' => '23', 'seconds' => 23));
        $this->assertEqual($duration->toString(), 'P3WT23M23S');
    
    }
    
    public function testNormalization() {
    
        $duration = new qCal\DateTime\Duration(array('days' => '345', 'minutes' => '1231541', 'seconds' => 23452345));
        $this->assertEqual($duration->toString(), 'P210W1DT16H13M25S');
        $duration = new qCal\DateTime\Duration(array('seconds' => 10000));
        $this->assertEqual($duration->toString(), 'PT2H46M40S');
        $duration = new qCal\DateTime\Duration(array('weeks' => 100));
        $this->assertEqual($duration->toString(), 'P100W');
        $duration = new qCal\DateTime\Duration(array('weeks' => 10, 'minutes' => '400', 'posneg' => '-'));
        $this->assertEqual($duration->toString(), '-P10WT6H40M');
        $duration = new qCal\DateTime\Duration(array('weeks' => 10, 'minutes' => '400', 'posneg' => '+'));
        $this->assertEqual($duration->toString(), 'P10WT6H40M');
    
    }

}