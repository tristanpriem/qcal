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
    qCal\DateTime\Date;

class UnitTestCase_Recurrence_Rule extends UnitTestCase {

    public function testInstantiateByDayRule() {
    
        $rule = new ByDay('SU');
        $this->assertEqual($rule->getValues(), array('SU'));
        
        $rule = new ByDay('1SU');
        $this->assertEqual($rule->getValues(), array('1SU'));
        
        $rule = new ByDay('-1MO');
        $this->assertEqual($rule->getValues(), array('-1MO'));
        
        $rule = new ByDay('+3TU');
        $this->assertEqual($rule->getValues(), array('+3TU'));
        
        $rule = new ByDay(array('1MO', 'TU', '-3SU'));
        $this->assertEqual($rule->getValues(), array('1MO', 'TU', '-3SU'));
    
    }
    
    public function testByDayThrowsExceptionIfInvalid() {
    
        $this->expectException(new \InvalidArgumentException('"FU" is not a valid weekday abbreviation.'));
        $rule = new ByDay('FU');
    
    }
    
    public function testByDayCheckDate() {
    
        $rule = new ByDay(array('1SU', '-1SU'));
        
        $dateGood = new Date(2008, 1, 6);
        $dateBad = new Date(2008, 1, 7);
        $this->assertTrue($rule->checkDate($dateGood));
        $this->assertFalse($rule->checkDate($dateBad));
        
        $dateGood = new Date(2008, 1, 27);
        $dateBad = new Date(2008, 1, 28);
        $this->assertTrue($rule->checkDate($dateGood));
        $this->assertFalse($rule->checkDate($dateBad));
    
    }
    
    public function testByHourInstantiate() {
    
        $hr = new ByHour(1);
        $this->assertEqual($hr->getValues(), array(1));
        
        $hr = new ByHour(array(1, 5, 12));
        $this->assertEqual($hr->getValues(), array(1, 5, 12));
    
    }
    
    public function testByHourThrowsExceptionIfInvalid() {
    
        $this->expectException(new \InvalidArgumentException('"35" is not a valid hour.'));
        $rule = new ByHour(35);
    
    }
    
    public function testByHourThrowsExceptionIfInvalidInArray() {
    
        $this->expectException(new \InvalidArgumentException('"45" is not a valid hour.'));
        $rule = new ByHour(array(1, 5, 24, 45));
    
    }
    
    public function testByHourThrowsExceptionIfHourIsNegative() {
    
        $this->expectException(new \InvalidArgumentException('"-10" is not a valid hour.'));
        $rule = new ByHour(array(1, -10, 24));
    
    }
    
    public function testByMinuteInstantiate() {
    
        $min = new ByMinute(1);
        $this->assertEqual($min->getValues(), array(1));
        
        $min = new ByMinute(array(1, 5, 12));
        $this->assertEqual($min->getValues(), array(1, 5, 12));
    
    }
    
    public function testByMinuteThrowsExceptionIfMinuteInvalid() {
    
        $this->expectException(new \InvalidArgumentException('"100" is not a valid minute.'));
        $rule = new ByMinute(array(1, 100, 24));
    
    }
    
    public function testByMinuteThrowsExceptionIfMinuteIsNegative() {
    
        $this->expectException(new \InvalidArgumentException('"-10" is not a valid minute.'));
        $rule = new ByMinute(array(1, -10, 24));
    
    }
    
    public function testByMonthInstantiate() {
    
        $mon = new ByMonth(1);
        $this->assertEqual($mon->getValues(), array(1));
        
        $mon = new ByMonth(array(1, 5, 10));
        $this->assertEqual($mon->getValues(), array(1, 5, 10));
        
        $mon = new ByMonth('january');
        $this->assertEqual($mon->getValues(), array(1));
        
        $mon = new ByMonth(array('january', 'march', 'december'));
        $this->assertEqual($mon->getValues(), array(1, 3, 12));
        
        $mon = new ByMonth(array('january', 2, 'march', 4, 'december'));
        $this->assertEqual($mon->getValues(), array(1, 2, 3, 4, 12));
    
    }
    
    public function testByMonthThrowsExceptionIfMonthInvalid() {
    
        $this->expectException(new \InvalidArgumentException('Month number must be between 1 and 12.'));
        $rule = new ByMonth(array(1, 100, 24));
    
    }
    
    public function testByMonthThrowsExceptionIfMonthNameInvalid() {
    
        $this->expectException(new \InvalidArgumentException('"foo" is not a valid month name.'));
        $rule = new ByMonth(array(1, 'foo', 5));
    
    }
    
    public function testByMonthCheckDate() {
    
        $rule = new ByMonth(array(1, 4, 6));
        $dateGood = new Date(2012, 1, 1);
        $dateBad = new Date(2012, 2, 1);
        $this->assertTrue($rule->checkDate($dateGood));
        $this->assertFalse($rule->checkDate($dateBad));
    
    }
    
    public function testByMonthDayInstantiate() {
    
        $mday = new ByMonthDay(10);
        $this->assertEqual($mday->getValues(), array(10));
        
        $mday = new ByMonthDay(array(10, 20, 30));
        $this->assertEqual($mday->getValues(), array(10, 20, 30));
    
    }
    
    public function testByMonthDayThrowsExceptionOnInvalidMonthDayNum() {
    
        $this->expectException(new \InvalidArgumentException('"100" is not a valid month day.'));
        $rule = new ByMonthDay(array(1, 100, 5));
    
    }
    
    public function testByMonthDayThrowsExceptionOnInvalidMonthDay() {
    
        $this->expectException(new \InvalidArgumentException('"foo" is not a valid month day.'));
        $rule = new ByMonthDay(array(1, 'foo', 5));
    
    }
    
    public function testByMonthDayAcceptsNegative() {
    
        $mday = new ByMonthDay(-10);
        $this->assertEqual($mday->getValues(), array(-10));
    
    }
    
    public function testByMonthDayCheckDate() {
    
        $rule = new ByMonthDay(array(1, 5, -10));
        
        $dateGood = new Date(2012, 1, 1);
        $dateGoodBackwards = new Date(2012, 1, 21);
        $dateBad = new Date(2012, 1, 2);
        $this->assertTrue($rule->checkDate($dateGood));
        $this->assertTrue($rule->checkDate($dateGoodBackwards));
        $this->assertFalse($rule->checkDate($dateBad));
    
    }
    
    public function testBySecondInstantiate() {
    
        $sec = new BySecond(10);
        $this->assertEqual($sec->getValues(), array(10));
        
        $sec = new BySecond(array(10, 20, 30));
        $this->assertEqual($sec->getValues(), array(10, 20, 30));
    
    }
    
    public function testBySecondThrowsExceptionOnInvalidSecondNum() {
    
        $this->expectException(new \InvalidArgumentException('"100" is not a valid second.'));
        $rule = new BySecond(array(1, 100, 5));
    
    }
    
    public function testBySecondThrowsExceptionOnInvalidSecond() {
    
        $this->expectException(new \InvalidArgumentException('"foo" is not a valid second.'));
        $rule = new BySecond(array(1, 'foo', 5));
    
    }
    
    public function testBySetPosInstantiate() {
    
        $setpos = new BySetPos(5);
        $this->assertEqual($setpos->getValues(), array(5));
        
        $setpos = new BySetPos(array(1, 5, 10));
        $this->assertEqual($setpos->getValues(), array(1, 5, 10));
        
        $setpos = new BySetPos(array(1, -5, 10));
        $this->assertEqual($setpos->getValues(), array(1, -5, 10));
    
    }
    
    public function testBySetPosThrowsExceptionOnInvalidSetPos() {
    
        $this->expectException(new \InvalidArgumentException('"foo" is not a valid set position.'));
        $setpos = new BySetPos('foo');
    
    }
    
    public function testByWeekNoInstantiate() {
    
        $weekno = new ByWeekNo(1);
        $this->assertEqual($weekno->getValues(), array(1));
        
        $weekno = new ByWeekNo(array(1, 3, 45));
        $this->assertEqual($weekno->getValues(), array(1, 3, 45));
        
        $weekno = new ByWeekNo(array(-1, -3, 45));
        $this->assertEqual($weekno->getValues(), array(-1, -3, 45));
    
    }
    
    public function testByWeekNoThrowsExceptionIfInvalidWeekNoNum() {
    
        $this->expectException(new \InvalidArgumentException('"54" is not a valid week number.'));
        $weekno = new ByWeekNo(54);
    
    }
    
    public function testByWeekNoThrowsExceptionIfInvalidWeekNoNumNeg() {
    
        $this->expectException(new \InvalidArgumentException('"-54" is not a valid week number.'));
        $weekno = new ByWeekNo(-54);
    
    }
    
    public function testByWeekNoThrowsExceptionIfInvalidWeekNoNumZero() {
    
        $this->expectException(new \InvalidArgumentException('"0" is not a valid week number.'));
        $weekno = new ByWeekNo(0);
    
    }
    
    public function testByWeekNoThrowsExceptionIfInvalidWeekNo() {
    
        $this->expectException(new \InvalidArgumentException('"foo" is not a valid week number.'));
        $weekno = new ByWeekNo('foo');
    
    }
    
    public function testByWeekNoCheckDate() {
    
        $rule = new ByWeekNo(array(1, 5, -2));
        
        $dateGood = new Date(2012, 1, 3);
        $dateGoodBackwards = new Date(2012, 12, 16);
        $dateBad = new Date(2012, 4, 23);
        
        $this->assertTrue($rule->checkDate($dateGood));
        $this->assertTrue($rule->checkDate($dateGoodBackwards));
        $this->assertFalse($rule->checkDate($dateBad));
    
    }
    
    public function testByYearDayInstantiate() {
    
        $yrday = new ByYearDay(1);
        $this->assertEqual($yrday->getValues(), array(1));
        
        $yrday = new ByYearDay(array(1, 3, 45));
        $this->assertEqual($yrday->getValues(), array(1, 3, 45));
        
        $yrday = new ByYearDay(array(-1, -3, 45));
        $this->assertEqual($yrday->getValues(), array(-1, -3, 45));
    
    }
    
    public function testByYearDayThrowsExceptionIfInvalidYearDay() {
    
        $this->expectException(new \InvalidArgumentException('"foo" is not a valid day of the year.'));
        $yrday = new ByYearDay('foo');
    
    }
    
    public function testByYearDayThrowsExceptionIfInvalidYearDayNum() {
    
        $this->expectException(new \InvalidArgumentException('"367" is not a valid day of the year.'));
        $yrday = new ByYearDay(367);
    
    }
    
    public function testByYearDayThrowsExceptionIfInvalidYearDayNumNeg() {
    
        $this->expectException(new \InvalidArgumentException('"-367" is not a valid day of the year.'));
        $yrday = new ByYearDay(-367);
    
    }
    
    public function testByYearDayThrowsExceptionIfInvalidYearDayNumZero() {
    
        $this->expectException(new \InvalidArgumentException('"0" is not a valid day of the year.'));
        $yrday = new ByYearDay(0);
    
    }
    
    public function testByYearDayCheckDate() {
    
        $rule = new ByYearDay(array(1, 15, -10));
        
        $dateGood = new Date(2012, 1, 1);
        $dateGoodBackwards = new Date(2012, 12, 21);
        $dateBad = new Date(2012, 8, 23);
        
        $this->assertTrue($rule->checkDate($dateGood));
        $this->assertTrue($rule->checkDate($dateGoodBackwards));
        $this->assertFalse($rule->checkDate($dateBad));
    
    }

}