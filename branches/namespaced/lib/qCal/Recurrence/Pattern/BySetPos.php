<?php
/**
 * BySetPos Recurrence Rule
 * After defining a recurrence pattern, this particular rule can be used to
 * select certain instances from within the recurrence pattern. So, if your
 * recurrence pattern selects every other day in January, and then you specify
 * this rule as "1" and "5", it will select the 1st and 5th instances in that
 * recurrence set.
 *
 * @package     qCal
 * @subpackage  Recurrence
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   Luke Visinoni <luke.visinoni@gmail.com>
 * @version     $Id$
 */
namespace qCal\Recurrence\Pattern;

class BySetPos extends Rule {

    protected function _validateValue($value) {
    
        $int = (integer) $value;
        $str = (string) $value;
        if ($str === (string) $int) {
            return true;
        }
        throw new \InvalidArgumentException(sprintf('"%s" is not a valid set position.', $value));
    
    }

}