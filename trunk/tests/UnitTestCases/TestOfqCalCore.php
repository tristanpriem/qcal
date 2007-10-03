<?php
class TestOfqCalCore extends UnitTestCase
{
    public function testqCalIsAComponent()
    {
        $cal = new qCal();
        $this->assertIsA($cal, 'qCal_Component_Abstract');
    }
    public function testqCalDefaults()
    {
        $cal = new qCal();
        $this->assertEqual($cal->getProperty('version')->__toString(), '2.0');
        $this->assertEqual($cal->getProperty('prodid')->__toString(), '-//MC2 Design Group, Inc.//qCal v' . qCal::VERSION . '//EN');
    }
    public function testqCalToString()
    {
        // test the __toString() method I guess
        $cal = new qCal();
    }
}