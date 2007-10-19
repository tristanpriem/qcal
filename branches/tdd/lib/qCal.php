<?php
require_once 'qCal/Component/vcalendar.php';
class qCal
{
    public function __construct()
    {
        throw new qCal_Exception('qCal cannot be instantiated. Use qCal::create()');
    }
    
    public static function create()
    {
        return new qCal_Component_vcalendar();
    }
}