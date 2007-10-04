<?php

Mock::Generate('qCal');

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
        $version = (string) $cal->getProperty('version');
        $prodid = (string) $cal->getProperty('prodid');
        $this->assertEqual($version, '2.0');
        $this->assertEqual($prodid, '-//MC2 Design Group, Inc.//qCal v' . qCal::VERSION . '//EN');
    }
    public function testqCalSerialize()
    {
    }
    public function testSendsRightContentType()
    {
    }
    // @todo: check that it is a requirement to have at least one component... I think it is - luke
    public function testToStringFailsWithoutAnyComponents()
    {
    }
    public function testCannotAddInvalidComponents()
    {
    }
    public function testCanAddValidComponents()
    {
    }
    public function testRemoveComponents()
    {
    }
    public function testEditComponent()
    {
    }
    public function testCannotAddInvalidProperties()
    {
    }
    public function testCanAddValidProperties()
    {
    }
    public function testRemoveProperties()
    {
    }
    public function testEditProperties()
    {
    }
}