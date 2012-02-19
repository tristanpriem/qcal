<?php
/**
 * Yearly recurrence pattern
 * This class allows the creation of date/time recurrence patterns that happen
 * on intervals of days. For instance, every year.
 * 
 * @package     qCal
 * @subpackage  Humanize
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   Luke Visinoni <luke.visinoni@gmail.com>
 * @version     $Id$
 */
namespace qCal\Recurrence;
use qCal\Recurrence\Pattern,
    qCal\Humanize,
    qCal\DateTime\Date,
    qCal\DateTime\DateTime;

class Yearly extends Pattern {

    public function next() {
    
        // find the next recurrence in the pattern
        
    
    }
    
    public function getRecurrences() {
    
        $rec = array();
        
        $start = $this->getStart();
        $until = $this->getUntil();
        
        $stYear = $start->getDate()->getYear();
        $unYear = $until->getDate()->getYear();
        
        /**
         * @todo Clean this up... maybe getRule() should always return an empty rule?
         */
        
        list($months, $weeknos, $yrdays, $modays, $days, $hours, $minutes, $seconds) = array(array(), array(), array(), array(), array(), array($start->getTime()->getHour()), array($start->getTime()->getMinute()), array($start->getTime()->getSecond()));
        if ($this->hasRule('ByMonth')) {
            $months = $this->getRule('ByMonth')->getValues();
        }
        if ($this->hasRule('ByWeekNo')) {
            $weeknos = $this->getRule('ByWeekNo')->getValues();
        }
        if ($this->hasRule('ByYearDay')) {
            $yrdays = $this->getRule('ByYearDay')->getValues();
        }
        if ($this->hasRule('ByMonthDay')) {
            $modays = $this->getRule('ByMonthDay')->getValues();
        }
        if ($this->hasRule('ByDay')) {
            $days = $this->getRule('ByDay')->getValues();
        }
        if ($this->hasRule('ByHour')) {
            $hours = $this->getRule('ByHour')->getValues();
        }
        if ($this->hasRule('ByMinute')) {
            $minutes = $this->getRule('ByMinute')->getValues();
        }
        if ($this->hasRule('BySecond')) {
            $seconds = $this->getRule('BySecond')->getValues();
        }
        
        $dates = array();
        $datetimes = array();
        $year = $stYear;
        while ($year <= $unYear) {
            // for every year interval, create instances of recurrences
            foreach ($months as $month) {
                foreach ($days as $day) {
                    $wdinfo = Humanize::weekDayNumAndAbbrToArray($day);
                    $date = Date::getXthWeekdayOfMonth($wdinfo['num'], $wdinfo['weekday'], $month, $year);
                    $dates[] = $date;
                }
            }
            $year += $this->getInterval();
        }
        foreach ($dates as $date) {
            foreach ($hours as $hour) {
                foreach ($minutes as $minute) {
                    foreach ($seconds as $second) {
                        $dt = new DateTime($date->getYear(), $date->getMonth(), $date->getDay(), $hour, $minute, $second);
                        $datetimes[$dt->toString('Y-m-d\TH:i:sO')] = $dt;
                    }
                }
            }
        }
    
    }

}