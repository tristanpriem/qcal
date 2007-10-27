<?php
require_once 'qCal/Attachable.php';
abstract class qCal_Property extends qCal_Attachable
{
    /**
     * This property's value
     */
    protected $value;
    /**
     * Class constructer - sets the property value
     * @var string - value of the property
     */
    public function __construct($value = null)
    {
        $this->value = $value;
    }
    /**
     * Return component in serialized form (icalendar format)
    public function render(qCal_Renderer $renderer = null)
    {
        if (is_null($renderer)) $renderer = new qCal_Renderer_Default;
        return $renderer->render($this);
    }
    
     */
    /**
     * Retrieve the value of this Property
     */
    public function getValue()
    {
        return $this->value;
    }
}