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
     * Tells whether a version is valid according to the rfc
     * @var string $version  The version number we're validating
     * @return bool
     * @todo: implement this
     */
    public static function isValidVersion($version)
    {
        return true;
    }
}