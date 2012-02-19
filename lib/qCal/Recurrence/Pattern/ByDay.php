<?php
/**
 * ByDay Recurrence Rule
 * This recurrence rule is used to specify the "weekday" rule for each recurrence
 * pattern type. For instance, if the recurrence pattern type is "monthly",
 * this specifies the wekkday(s) for which to apply it. For instance "MO" for
 * monday, and "-1SU" for the last Sunday of the month.
 *
 * @package     qCal
 * @subpackage  Recurrence
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   Luke Visinoni <luke.visinoni@gmail.com>
 * @version     $Id$
 */
namespace qCal\Recurrence\Pattern;
use qCal\Humanize,
    qCal\DateTime\Date;

class ByDay extends Rule {

    // @todo Use Humanize::weekDayNumAndAbbrToArray() here
    protected function _validateValue($value) {
    
        if (preg_match('~([+-]?[0-9]{1,2})?([A-Z]{2})~i', $value, $matches)) {
            $abbr = $matches[2];
            // This will throw an exception if $abbr is invalid
            Humanize::weekDayAbbrToNum($abbr);
            return true;
        }
        return false;
    
    }
    
    /**
     * 
     */
    public function checkDate(Date $date) {
    
        $wdname = Humanize::weekDayNameToAbbr($date->getWeekDayName());
        foreach ($this->getValues() as $value) {
            $wdinfo = Humanize::weekDayNumAndAbbrToArray($value);
            $xth = Date::getXthWeekdayOfMonth($wdinfo['num'], $wdinfo['weekday'], $date->getMonth(), $date->getYear());
            if ($xth->toString('Ymd') == $date->toString('Ymd')) return true;
        }
    
    }

}