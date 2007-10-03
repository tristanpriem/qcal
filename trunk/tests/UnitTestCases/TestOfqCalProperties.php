<?php
/**
 * Testing everything related to qCal_Property_Abstract
 */
class TestOfqCalProperties extends UnitTestCase
{
    public function testRequiredqCalProperties()
    {
        $cal = new qCal();
        $cal->addComponent(new qCal());
        
        echo '<pre>';
        echo $cal;
        echo '</pre>';
    }
}