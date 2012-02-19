<?php
/**
 * ByWeekNo Recurrence Rule
 * This recurrence rule is used to specify the "week number" rule for each 
 * recurrence pattern type. For instance, if the recurrence pattern type is 
 * "daily", this specifies the week(s) of the year for which to apply it. 
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

class ByWeekNo extends Rule {

    protected function _validateValue($value) {
    
        $int = (integer) $value;
        if (($int > 0 && $int <= 53) || ($int < 0 && $int >= -53)) {
            return true;
        }
        throw new \InvalidArgumentException(sprintf('"%s" is not a valid week number.', $value));
    
    }
    
    /**
     * @todo Make sure this can be passed the correct day to start the week
     */
    public function checkDate(Date $date) {
    
        foreach ($this->getValues() as $value) {
            $int = (integer) $value;
            if (abs($int) !== $int) {
                // negative
                if ($date->getWeeksUntilEndOfYear() == abs($value)) return true;
            } else {
                // positive
                if ($date->getWeekOfYear() == $value) return true;
            }
        }
        return false;
    
    }

}