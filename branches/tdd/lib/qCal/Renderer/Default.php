<?php
class qCal_Renderer_Default extends qCal_Renderer
{
    /**
     * All components start with BEGIN:
     */
    const BEGIN = 'BEGIN:';
    /**
     * All components end with END:
     */
    const END = 'END:';
    /**
     * Return component in icalendar format
     */
    public function render(qCal_Component $component)
    {
        // this will contain all the lines in this component's serialization
        $lines = array();
        $lines[] = strtoupper(self::BEGIN . $component->getType());
        
        foreach ($component->getChildren() as $child)
        {
            if ($child instanceof qCal_Component)
            {
                $lines[] = $this->render($child);
            }
            elseif ($child instanceof qCal_Property)
            {
                $lines[] = $this->renderProperty($child);
            }
        }
        
        $lines[] = strtoupper(self::END . $component->getType());
        
        return implode(qCal::LINE_ENDING, $lines);
    }
    protected function renderProperty(qCal_Property $property)
    {
        return $child->getType() . ':' . $child->getValue();
    }
}

/**
strtoupper(self::BEGIN . $child->getType());


        
        **/