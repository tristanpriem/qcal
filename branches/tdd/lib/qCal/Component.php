<?php
require_once 'qCal/Attachable.php';
abstract class qCal_Component extends qCal_Attachable
{
    public function attach(qCal_Attachable $attachable)
    {
        if (!$attachable->canAttachTo($this))
        {
            throw new qCal_Exception('You have supplied an invalid object to qCal_Component::attach');
        }
        return true;
    }
}