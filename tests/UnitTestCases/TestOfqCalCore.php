<?php
class TestOfqCalCore extends UnitTestCase
{
    public function testqCalIsAComponent()
    {
        $cal = new qCal();
        $this->assertIsA($cal, 'qCal_Component_Abstract');
    }
}