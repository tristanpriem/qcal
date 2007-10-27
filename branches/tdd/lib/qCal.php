<?php
require_once 'qCal/Component/vcalendar.php';
class qCal
{
    const LINE_ENDING = "\r\n";
    public function __construct()
    {
        throw new qCal_Exception('qCal cannot be instantiated. Use qCal::create()');
    }
    
    public static function create()
    {
        return new qCal_Component_vcalendar();
    }
}