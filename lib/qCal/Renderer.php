<?php
abstract class qCal_Renderer
{
    // might change to qCal_Component_vcalendar
    abstract public function render(qCal_Component $cal);
}