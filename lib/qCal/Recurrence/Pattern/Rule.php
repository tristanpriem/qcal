<?php
namespace qCal\Recurrence\Pattern;
use qCal\Humanize,
    qCal\Date;

abstract class Rule {

    protected $_values = array();
    
    public function __construct($values) {
    
        $this->setValues($values);
    
    }
    
    public function setValues($values) {
    
        if (!is_array($values)) $values = (array) $values;
        foreach ($values as $value) {
            if ($this->_validateValue($value)) {
                $this->_values[] = $this->_convertValue($value);
            }
        }
        return $this;
    
    }
    
    public function getValues() {
    
        return $this->_values;
    
    }
    
    protected function _convertValue($value) {
    
        return $value;
    
    }
    
    public function checkDate(Date $date) {
    
        return true;
    
    }
    
    abstract protected function _validateValue($value);

}