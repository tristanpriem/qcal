<?php
/**
 * qCal Base Class
 * Used for getting version and that type of thing
 * @todo This should be qCal_Version if anything at all. I originally created it
 * because I didn't fully understand PHP's namespace system but now I do so it
 * can probably go unless I need the Version stuff.
 */
namespace qCal;

final class qCal {

    const VERSION = '0.01';
    
    public function getVersionName() {
    
        return sprintf('qCal %2.00s', self::VERSION);
    
    }

}