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
        //pre($ical);
    
    }
    
    public function testLongLinesFolded() {
    
    	$cal = new qCal;
    	$todo = new qCal_Component_Todo(array(
	    	'description' => 'This is a really long line that will of course need to be folded. I mean, we can\'t just have long lines laying around in an icalendar file. That would be like not ok. So, let\'s find out if this folded properly!',
			'summary' => 'This is a short summary, which I think is like a title',
			'dtstart' => '2008-04-23 1:00am',
    	));
    	$cal->attach($todo);
    	$journal = new qCal_Component_Journal(array(
	    	'description' => 'This is a really long line that will of course need to be folded. I mean, we can\'t just have long lines laying around in an icalendar file. That would be like not ok. So, let\'s find out if this folded properly!',
			'summary' => 'This is a short summary, which I think is like a title',
			'dtstamp' => '2008-04-23 1:00am',
			new qCal_Property_Attach(file_get_contents('./files/me.jpg'), array(
				'encoding' => 'base64',
				'fmtype' => 'image/basic',
				'value' => 'binary',
			)),
    	));
    	$cal->attach($journal);
    	pre($cal->render());
    
    }
    
    public function testBinaryData() {
    
    	
    
    }

}