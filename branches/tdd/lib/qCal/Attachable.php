<?php

abstract class qCal_Attachable
{
    /**
     * Attachable's name (generally this is the type of component or property (vcalendar, prodid, etc.)
     */
    protected $_name;
    protected $_validParents = array();
    /**
     * Is the component this is being added to allowed?
     */
    public function allowsParent(qCal_Component $component)
    {
        return (in_array($component->getType(), $this->_validParents));
    }
    /**
     * Tells whether this component is RFC-Compliant
     *
     * @returns boolean
     */
    public function isValid()
    {
        return true;
    }
    abstract public function serialize();
}