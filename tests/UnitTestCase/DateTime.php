<?php
/**
 * Test cases for date and time classes
 */
use qCal\DateTime\DateTime\Base,
    qCal\DateTime\DateTime\Timezone,
    qCal\DateTime\DateTime\Date,
    qCal\DateTime\DateTime\Time,
    qCal\DateTime\DateTime\DateTime;

class UnitTestCase_DateTime extends \UnitTestCase {

    protected $_origServerTZ;
    
    protected $_testServerTZ = 'America/Los_Angeles';
    
    public function setUp() {
    
        // store original server default
        $this->_origServerTZ = date_default_timezone_get();
        date_default_timezone_set($this->_testServerTZ);
    
    }
    
    public function tearDown() {
    
        // set back to original default server time
        date_default_timezone_set($this->_origServerTZ);
    
    }

}