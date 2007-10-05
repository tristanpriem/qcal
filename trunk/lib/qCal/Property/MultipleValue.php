<?php 
require 'qCal/Property/Abstract.php';
abstract class qCal_Property_MultipleValue extends qCal_Property_Abstract
{
    protected $_multiple = true;
    protected $_value = array();
}