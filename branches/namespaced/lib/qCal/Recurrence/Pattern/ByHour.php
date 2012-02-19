<?php
/**
 * ByHour Recurrence Rule
 * This recurrence rule is used to specify the "hour" rule for each recurrence
 * pattern type. For instance, if the recurrence pattern type is "daily",
 * this specifies the hour(s) for which to apply it.
 *
 * @package     qCal
 * @subpackage  Recurrence
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   Luke Visinoni <luke.visinoni@gmail.com>
 * @version     $Id$
 */
namespace qCal\Recurrence\Pattern;
use qCal\DateTime\Time;

class ByHour extends Rule {

    protected function _validateValue($value) {
    
        if ((integer) $value > 24 || (integer) $value < 0) {
            // @todo maybe throw OutOfBoundsException here instead?
            throw new \InvalidArgumentException(sprintf('"%d" is not a valid hour.', $value));
        }
        return true;
    
    }

}