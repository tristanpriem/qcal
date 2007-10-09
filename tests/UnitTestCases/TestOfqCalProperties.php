<?php
/**
 * Testing everything related to qCal_Property
 */
class TestOfqCalProperties extends UnitTestCase
{
    public function testSetParam()
    {
        
    }
    public function testEditParam()
    {
    }
    public function testRemoveParam()
    {
    }
    public function testSerialize()
    {
    }

    public function testRequiredqCalProperties()
    {
        // $cal = new qCal();
        // $cal->addComponent(new qCal());
        
        // wouldn't this be adding a 
        // blank calendar?  i.e., shouldn't
        // this throw an error of some sort?
        
        // if you mean adding an iCal to an iCal, yea probably. I haven't got there yet.
        // I only did that to show you that you can already add a component to another component
        // if we were to test that, it'd probably go in TestOfqCalCore (look in there) - luke
        
        // OK I did some research - you actually CAN add a calendar to another calendar according
        // source: wikipedia, so it could be wrong although I Don't think it is, we'll have to check the rfc
        // http://en.wikipedia.org/wiki/ICalendar - under "core object" - good source of info if you haven't read it - luke
        
        /**************
         * Not sure if these belong here,
         * or if they're even remotely the
         * right format, hence the mad commenting.
         *
         * $birthday = new qCalEvent();
         * $birthday->setProperty('starttime' $time_event_starts)
         * 
         * right format for what? -luke
         * ***********/
    }
}
