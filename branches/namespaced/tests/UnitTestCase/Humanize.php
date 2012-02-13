<?php

use qCal\Humanize;

class UnitTestCase_Humanize extends \UnitTestCase {

    public function testOrdinalConversion() {
    
        $this->assertEqual(Humanize::ordinal(0), '0th');
        $this->assertEqual(Humanize::ordinal(1), '1st');
        $this->assertEqual(Humanize::ordinal(2), '2nd');
        $this->assertEqual(Humanize::ordinal(3), '3rd');
        $this->assertEqual(Humanize::ordinal(4), '4th');
        $this->assertEqual(Humanize::ordinal(5), '5th');
        $this->assertEqual(Humanize::ordinal(6), '6th');
        $this->assertEqual(Humanize::ordinal(7), '7th');
        $this->assertEqual(Humanize::ordinal(8), '8th');
        $this->assertEqual(Humanize::ordinal(9), '9th');
        $this->assertEqual(Humanize::ordinal(10), '10th');
        $this->assertEqual(Humanize::ordinal(11), '11th');
        $this->assertEqual(Humanize::ordinal(12), '12th');
        $this->assertEqual(Humanize::ordinal(13), '13th');
        
        $this->assertEqual(Humanize::ordinal(101), '101st');
        $this->assertEqual(Humanize::ordinal(111), '111th');
    
    }

}