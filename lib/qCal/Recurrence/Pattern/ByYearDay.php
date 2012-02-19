<?php
/**
 * ByYearDay Recurrence Rule
 * This recurrence rule is used to specify the "day of the year" rule for each 
 * recurrence pattern type. For instance, if the recurrence pattern type is 
 * "yearly", this specifies the day(s) of the year for which to apply it. 
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

class ByYearDay extends Rule {

    protected function _validateValue($value) {
    
        $int = (integer) $value;
        if (($int > 0 && $int <= 366) || ($int < 0 && $int >= -366)) {
            return true;
        }
        throw new \InvalidArgumentException(sprintf('"%s" is not a valid day of the year.', $value));
    
    }
    
    public function checkDate(Date $date) {
    
        foreach ($this->getValues() as $value) {
            $int = (integer) $value;
            if (abs($int) !== $int) {
                // negative
                if ($date->getNumDaysUntilEndOfYear() == abs($value)) return true;
            } else {
                // positive
                if ($date->getYearDay(true) == $value) return true;
            }
        }
        return false;
    
    }

}