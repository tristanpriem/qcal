<?php
require_once 'qCal/Attachable.php';
abstract class qCal_Component extends qCal_Attachable
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
     * Return component in serialized form (icalendar format)
     */
    public function serialize()
    {
        // this will contain all the lines in this component's serialization
        $lines = array();
        // uppercase the name of this component
        $lines[] = strtoupper(self::BEGIN . $this->getType());
        // give me all of my children in serialized form as well
        foreach ($this->children as $child) $lines[] = $child->serialize();
        // now wrap it up with an END
        $lines[] = strtoupper(self::END . $this->getType());
        // return in right format
        return implode(qCal::LINE_ENDING, $lines);
    }
}