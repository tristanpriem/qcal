<?php
abstract class qCal_Attachable
{
    protected $type;
    public function getType()
    {
        return $this->type;
    }
    public function canAttachTo(qCal_Component $component)
    {
    }
}