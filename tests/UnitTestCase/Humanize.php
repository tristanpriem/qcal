<?php

use qCal\Humanize;

class UnitTestCase_Humanize extends \UnitTestCase {


    public function testConvertAbbrDayToNum() {
    
        $this->assertEqual(qCal\Humanize::weekDayNameToNum('tu'), 2);
        $this->assertEqual(qCal\Humanize::weekDayNameToNum('SU'), 0);
    
    }
    
    public function testConvertWholeDayToNum() {
    
        $this->assertEqual(qCal\Humanize::weekDayNameToNum('Tuesday'), 2);
        $this->assertEqual(qCal\Humanize::weekDayNameToNum('SUNDAY'), 0);
    
    }
    
    public function testWeekDayToNumReturnsNumIfPassedValidNum() {
    
        $this->assertEqual(qCal\Humanize::weekDayNameToNum(2), 2);
        $this->assertEqual(qCal\Humanize::weekDayNameToNum(0), 0);
    
    }
    
    // name to number returns the number if its valid, otherwise it throws an exception
    public function testWeekDayNameToNumThrowsExceptionIfPassedInvalidNum() {
    
        $this->expectException(new InvalidArgumentException('Weekday number must be between 0 (Sunday) and 6 (Saturday).'));
        qCal\Humanize::weekDayNameToNum(20);
    
    }
    
    public function testWeekNumToName() {
    
        $this->assertEqual(qCal\Humanize::weekDayNumToName(1), 'monday');
        $this->assertEqual(qCal\Humanize::weekDayNumToName(5), 'friday');
    
    }
    
    public function testWeekDayNumToNameReturnsNameIfPassedValidName() {
    
        $this->assertEqual(qCal\Humanize::weekDayNumToName('monday'), 'monday');
        $this->assertEqual(qCal\Humanize::weekDayNumToName('Friday'), 'friday');
    
    }
    
    public function testWeekDayNumToNameThrowsExceptionIfPassedInValidNum() {
    
        $this->expectException(new InvalidArgumentException('Weekday number must be between 0 (Sunday) and 6 (Saturday).'));
        qCal\Humanize::weekDayNumToName(10);
    
    }
    
    public function testWeekDayToNumThrowsExceptionIfInvalidArg() {
    
        $this->expectException(new InvalidArgumentException('"pokemon" is not a valid weekday name.'));
        qCal\Humanize::weekDayNameToNum('pokemon');
    
    }
    
    public function testConvertMonthNameToNum() {
    
        $this->assertEqual(qCal\Humanize::monthNameToNum('february'), 2);
        $this->assertEqual(qCal\Humanize::monthNameToNum('December'), 12);
    
    }
    
    public function testMonthNameToNumReturnsNumIfPassedNum() {
    
        $this->assertEqual(qCal\Humanize::monthNameToNum(2), 2);
        $this->assertEqual(qCal\Humanize::monthNameToNum(12), 12);
    
    }
    
    public function testMonthNameToNumThrowsExceptionIfInvalidArg() {
    
        $this->expectException(new InvalidArgumentException('"pokemon" is not a valid month name.'));
        qCal\Humanize::monthNameToNum('pokemon');
    
    }
    
    public function testMonthNumToName() {
    
        $this->assertEqual(qCal\Humanize::monthNumToName(1), 'january');
        $this->assertEqual(qCal\Humanize::monthNumToName(5), 'may');
    
    }
    
    // num to name returns name if passed a valid name
    public function testMonthNumToNameReturnsNameIfPassedValidName() {
    
        $this->assertEqual(qCal\Humanize::monthNumToName('january'), 'january');
        $this->assertEqual(qCal\Humanize::monthNumToName('May'), 'may');
    
    }
    
    // this method accepts numbers and just returns them as long as they're valid, otherwise it throws an exception
    public function testMonthNumToNameThrowsExceptionIfPassedInvalidNum() {
    
        $this->expectException(new InvalidArgumentException('Month number must be between 1 and 12.'));
        qCal\Humanize::monthNumToName(20);
    
    }
    
    public function testMonthNameToNumThrowsExceptionOnInvalidNum() {
    
        $this->expectException(new InvalidArgumentException('Month number must be between 1 and 12.'));
        qCal\Humanize::monthNameToNum(15);
    
    }
    
    public function testMonthNumToNameCanCapitalizeName() {
    
        $this->assertEqual(qCal\Humanize::monthNumToName(1), 'january');
        $this->assertEqual(qCal\Humanize::monthNumToName(1, true), 'January');
    
    }
    
    public function testWeekdayNumToNameCanCapitalizeName() {
    
        $this->assertEqual(qCal\Humanize::weekDayNumToName(1), 'monday');
        $this->assertEqual(qCal\Humanize::weekDayNumToName(1, true), 'Monday');
    
    }
    
    public function testWeekdayNameToAbbr() {
    
        $this->assertEqual(qCal\Humanize::weekDayNameToAbbr('monday'), 'MO');
        $this->assertEqual(qCal\Humanize::weekDayNameToAbbr('Tuesday'), 'TU');
        $this->assertEqual(qCal\Humanize::weekDayNameToAbbr('WEDNESDAY'), 'WE');
        $this->assertEqual(qCal\Humanize::weekDayNameToAbbr('thursday'), 'TH');
        $this->assertEqual(qCal\Humanize::weekDayNameToAbbr('friday'), 'FR');
        $this->assertEqual(qCal\Humanize::weekDayNameToAbbr('satuRDAY'), 'SA');
        $this->assertEqual(qCal\Humanize::weekDayNameToAbbr('sunDay'), 'SU');
    
    }
    
    public function testWeekdayNameToAbbrThrowsExceptionOnInvalidWeekDayName() {
    
        $this->expectException(new InvalidArgumentException('"FU" is not a valid weekday abbreviation.'));
        qCal\Humanize::weekDayAbbrToName('fu');
    
    }
    
    public function testWeekdayAbbrToName() {
    
        $this->assertEqual(qCal\Humanize::weekDayAbbrToName('MO'), 'monday');
        $this->assertEqual(qCal\Humanize::weekDayAbbrToName('WE'), 'wednesday');
        $this->assertEqual(qCal\Humanize::weekDayAbbrToName('SU'), 'sunday');
    
    }
    
    public function testWeekdayAbbrToNameThrowsExceptionOnInvalidWeekdayAbbr() {
    
        $this->expectException(new InvalidArgumentException('"funday" is not a valid weekday name.'));
        qCal\Humanize::weekDayNameToAbbr('funday');
    
    }
    
    public function testWeekdayAbbrToNum() {
    
        $this->assertEqual(qCal\Humanize::weekDayAbbrToNum('MO'), 1);
        $this->assertEqual(qCal\Humanize::weekDayAbbrToNum('WE'), 3);
        $this->assertEqual(qCal\Humanize::weekDayAbbrToNum('FR'), 5);
    
    }
    
    public function testWeekDayAbbrToNumThrowsExceptionOnInvalidAbbr() {
    
        $this->expectException(new InvalidArgumentException('"FU" is not a valid weekday abbreviation.'));
        qCal\Humanize::weekDayAbbrToNum('fu');
    
    }
    
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