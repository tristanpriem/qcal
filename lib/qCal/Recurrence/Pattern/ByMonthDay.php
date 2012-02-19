<?php
/**
 * ByMonthDay Recurrence Rule
 * This recurrence rule is used to specify the "day of the month" rule for each 
 * recurrence pattern type. For instance, if the recurrence pattern type is 
 * "monthly", this specifies the day(s) of the month for which to apply it. 
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

class ByMonthDay extends Rule {

    /**
     * @todo Is it possible to determine if this month day is valid for its
     * particular month?
     */
    protected function _validateValue($value) {
    
        $int = (integer) $value;
        if (($int > 0 && $int <= 31) || ($int < 0 && $int >= -31)) {
            return true;
        }
        throw new \InvalidArgumentException(sprintf('"%s" is not a valid month day.', $value));
    
    }
    
    /**
     * 
     */
    public function checkDate(Date $date) {
    
        foreach ($this->getValues() as $value) {
            $int = (integer) $value;
            if (abs($int) !== $int) {
                // negative
                if ($date->getNumDaysUntilEndOfMonth() == abs($value)) return true;
            } else {
                // positive
                if ($date->getDay() == $value) return true;
            }
        }
        return false;
    
    }

}