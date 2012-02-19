<?php
/**
 * ByMinute Recurrence Rule
 * This recurrence rule is used to specify the "minute" rule for each recurrence
 * pattern type. For instance, if the recurrence pattern type is "hourly",
 * this specifies the minute for which to apply it.
 *
 * @package     qCal
 * @subpackage  Recurrence
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   Luke Visinoni <luke.visinoni@gmail.com>
 * @version     $Id$
 */
namespace qCal\Recurrence\Pattern;
use qCal\DateTime\Time;

class ByMinute extends Rule {

    protected function _validateValue($value) {
    
        $int = (integer) $value;
        $str = (string) $value;
        if ($str === (string) $int) {
            if ($int >= 0 && $int < 60) {
                return true;
            }
        }
        throw new \InvalidArgumentException(sprintf('"%s" is not a valid minute.', $value));
    
    }

}