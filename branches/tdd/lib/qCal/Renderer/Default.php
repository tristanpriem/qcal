<?php
class qCal_Renderer_Default extends qCal_Renderer
{
    // might change to qCal_Component_vcalendar
    // @todo: output & test correcte content-type, etc.
    public function render(qCal_Component $cal)
    {
        return $cal->serialize();
    }
}