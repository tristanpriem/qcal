<?php 
require_once 'qCal/Property.php';
abstract class qCal_Property_MultipleValue extends qCal_Property
{
    protected $_multiple = true;
    protected $_value = array();
    public function addValue($value)
    {
        $this->_value[] = $value;
    }
    public function getValue()
    {
        return $this->_value;
    }
    public function serialize()
    {
        $lines = array();
        foreach ($this->_value as $value)
        {
            $lines[] = $this->getType() . ':' . $value;
        }
        return implode(qCal::LINE_ENDING, $lines);
    }
}