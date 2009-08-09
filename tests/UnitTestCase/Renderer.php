<?php
class UnitTestCase_Renderer extends UnitTestCase {

    public function setUp() {
    
        
    
    }
    
    public function tearDown() {
    
        
    
    }
    
    public function NOSHOWtestRenderer() {
    
    	$calendar = new qCal;
    	$calendar->attach(new qCal_Component_Todo());
    	$alarm = new qCal_Component_Alarm(array('action' => 'audio', 'trigger' => '15m'));
    	$todo_w_alarm = new qCal_Component_Todo();
    	$todo_w_alarm->setDescription("Remember to eat a pile of bacon soda", array('altrep' => 'This is an alternate representation'));
    	$todo_w_alarm->setDue("2008-12-25 8:00");
    	$todo_w_alarm->attach($alarm);
    	$calendar->attach($todo_w_alarm);
        $ical = $calendar->render(); // can pass it a renderer, otherwise it uses ical format
        // pre($ical);
    
    }
    /**
     * @todo Remove the binary attach stuff from here and put it in the test below.
     */
    public function testLongLinesFolded() {
    
    	$cal = new qCal;
    	$todo = new qCal_Component_Vtodo(array(
	    	'description' => 'This is a really long line that will of course need to be folded. I mean, we can\'t just have long lines laying around in an icalendar file. That would be like not ok. So, let\'s find out if this folded properly!',
			'summary' => 'This is a short summary, which I think is like a title',
			'dtstart' => '2008-04-23 1:00am',
    	));
    	$cal->attach($todo);
    	$journal = new qCal_Component_Vjournal(array(
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
		$lines = explode("\r\n", $cal->render());
		$long = false;
		foreach ($lines as $line) {
			if (strlen($line) > 76) $long = true;
		}
		$this->assertFalse($long);
    
    }
    /**
     * Test that binary data can be encoded as text and then decoded to be put back together.
     */
    public function testBinaryData() {
    
    	
    
    }
	/**
	 * Test that all of the right characters are escaped when rendered
	 */
	public function testCharactersAreEscaped() {
	
		
	
	}

}