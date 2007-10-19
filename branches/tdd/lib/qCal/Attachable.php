<?php
class qCal_Attachable
{
    public function attach()
    {
        throw new qCal_Exception('qCal_Component::attach() can only accept an instance of qCal_Attachable');
    }
}