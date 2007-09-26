<?php

class qCal_rfc2445
{
    /**
     * Internet standard newline
     */
    const LINE_ENDING = "\r\n";
    /**
     * The longest a line can be before it must be folded
     */
    const LINE_FOLD_LENGTH = 75;
    /**
     * Allowed parameters and components
     */
    protected static $_allowedParams = array (
        'vcalendar' => array (
                          'calscale',
                          'method',
                          'prodid',
                          'version',
                          'method'
                       )
    )
    /**
     * Tells whether a version is valid according to the rfc
     * @var string $version  The version number we're validating
     * @return bool
     * @todo: implement this
     */
    public static function isValidVersion($version)
    {
        return true;
    }
    
    public static function getAllowedParams($component_type)
    {
        $return = array()
        switch ($component_type)
        {
            if (in_array($param, $compunent_type))
            {
            }
            case "vcalendar":
                return array();
                break;
        }
    }
}