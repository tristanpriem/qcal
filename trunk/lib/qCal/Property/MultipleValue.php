<?php 
require 'qCal/Property.php';
abstract class qCal_Property_MultipleValue extends qCal_Property
{
    protected $_multiple = true;
    protected $_value = array();
    public function serialize()
    {
        $lines = array();
        foreach ($this->_value as $value)
        {
            $lines[] = $this->getValue() . ':' . $this->getValue();
        }
        return implode(qCal::LINE_ENDING, $lines);
    }
}