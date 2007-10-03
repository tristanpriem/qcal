<?php
/**
 * Testing everything related to qCal_Property_Abstract
 */
class TestOfqCalProperties extends UnitTestCase
{
    public function testRequiredqCalProperties()
    {
        $cal = new qCal();
	$cal->addComponent(new qCal()); //wouldn't this be adding a 
					//blank calendar?  i.e., shouldn't
					//this throw an error of some sort?
	/**************
	 * Not sure if these belong here,
	 * or if they're even remotely the
	 * right format, hence the mad commenting.
	 *
	 * $birthday = new qCalEvent();
	 * $birthday->setProperty('starttime' $time_event_starts)
	 * ***********/
        
        echo '<pre>';
        echo $cal;
        echo '</pre>';
    }
}
