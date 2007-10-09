<?php
require_once 'qCal/Property.php';
class Mock_qCal_Property extends qCal_Property
{
    protected $_name = 'QCALTESTPROPERTY';
    public function evaluateIsValid()
    {
        return true;
    }
    public function format($value)
    {
        return $value;
    }
}