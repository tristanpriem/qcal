<?php
/**
 * ByMonth Recurrence Rule
 * This recurrence rule is used to specify the "month" rule for each 
 * recurrence pattern type. For instance, if the recurrence pattern type is 
 * "daily", this specifies the month(s) for which to apply it. 
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

class ByMonth extends Rule {

    protected function _validateValue($value) {
    
        // This will throw an exception if month is invalid
        $month = Humanize::monthNameToNum($value);
        return true;
    
    }
    
    protected function _convertValue($value) {
    
        return Humanize::monthNameToNum($value);
    
    }
    
    public function checkDate(Date $date) {
    
        return in_array($date->getMonth(), $this->getValues());
    
    }

}