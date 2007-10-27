<?php
/**
 * A qCal_Attachable is anything that can be attached to something else
 * A qCal_Attachable also means that things can attach to it!
 *
 * Attachables can be properties, components, and parameters
 */
abstract class qCal_Attachable
{
    /**
     * @var string The type of this "attachable" such as VCALENDAR, VEVENT, METHOD, etc
     */
    protected $type;
    /**
     * @var array of attachables that are attached to this object
     */
    protected $children;
    /**
     * Public accessor for private $type
     */
    public function getType()
    {
        return strtoupper($this->type);
    }
    /**
     * Tells another attachable (component for now) whether it is 
     * capable of being attached to it (this will probably change
     * to qCal_Attachable instead of qCal_Component)
     */
    public function canAttachTo(qCal_Component $component)
    {
    }
    public function attach(qCal_Attachable $attachable)
    {
        if (!$attachable->canAttachTo($this))
        {
            throw new qCal_Exception('You have supplied an invalid object to qCal_Component::attach');
        }
        // adds type as key for easy look-up
        $this->children[$attachable->getType()] = $attachable;
        return true;
    }
    /**
     * Get a property, component, or parameter value from this attachable
     *
     * @var string - the "type" of attachable you would like to "get"
     * @returns false|qCal_Attachable - the attachable of type $type
     */
    public function get($type)
    {
        return array_key_exists($type, $this->children) ? $this->children[$type] : false;
    }
}