<?php

class qCal
{
    public function __construct()
    {
        throw new qCal_Exception('qCal cannot be instantiated. Use qCal::create()');
    }
    
    public static function create()
    {
    }
}