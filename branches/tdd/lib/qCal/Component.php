<?php
require_once 'qCal/Attachable.php';
abstract class qCal_Component extends qCal_Attachable
{
    /**
     * Return component in serialized form (icalendar format)
     */
    public function render(qCal_Renderer $renderer = null)
    {
        if (is_null($renderer)) $renderer = new qCal_Renderer_Default;
        return $renderer->render($this);
    }
}