<?php
class UnitTestCase_Renderer extends UnitTestCase {

    public function setUp() {
    
        
    
    }
    
    public function tearDown() {
    
        
    
    }
    
    public function testRenderer() {
    
    	$calendar = new qCal;
    	$calendar->attach(new qCal_Component_Todo());
    	$alarm = new qCal_Component_Alarm(array('action' => 'audio', 'trigger' => '15m'));
    	$todo_w_alarm = new qCal_Component_Todo();
    	$todo_w_alarm->setDescription("Remember to eat a pile of bacon soda", array('altrep' => 'This is an alternate representation'));
    	$todo_w_alarm->setDue("2008-12-25 8:00");
    	$todo_w_alarm->attach($alarm);
    	$calendar->attach($todo_w_alarm);
        $ical = $calendar->render(); // can pass it a renderer, otherwise it uses ical format
        pre($ical);
    
    }

}