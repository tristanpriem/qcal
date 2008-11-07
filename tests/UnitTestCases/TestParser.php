<?php
require_once QCAL_PATH . '/Parser.php';
class TestParser extends UnitTestCase {

    public function setUp() {
    
        
    
    }
    
    public function tearDown() {
    
        
    
    }
    
    public function testParser() {
    
        $parser = new qCal_Parser('./files/simple.ics');
        $calendar = $parser->parse(); // now we have an iterable collection of event, todo, etc objects in $calendar
    
    }

}