<?php

set_include_path(
    //'\\\\Mc2-server\\Software Downloads\\PHP Libs' . PATH_SEPARATOR .
    //'\\\\Mc2-server\\Projects\\MC2 Design\\002967_qCal_ Library_and_App\\Web_Build\\lib' . PATH_SEPARATOR .
    'C:\\htdocs\\qCal\\lib' . PATH_SEPARATOR .
    'C:\\phplib' . PATH_SEPARATOR .
    // add simpletest directory here
    get_include_path()
);

require_once 'simpletest/unit_tester.php';
require_once 'simpletest/reporter.php';
require_once 'simpletest/mock_objects.php';

require_once 'qCal.php';
require_once 'qCal/Component/Abstract.php';
require_once 'qCal/Property/Abstract.php';
require_once 'qCal/Property/Factory.php';

// used for debugging in html
function d($value)
{
    echo '<pre>';
    echo var_dump($value);
    echo '</pre>';
}

class TestOfqCalCore extends UnitTestCase
{
    public function testDefaults()
    {
        $cal = new qCal();
        $this->assertEqual($cal->getProperty('prodid'), '-//MC2 Design Group, Inc.//qCal v' . qCal::VERSION . '//EN');
        // @todo: we may not want to default to 2.0 - not sure yet
        $this->assertEqual($cal->getProperty('version'), '2.0');
    }
    public function testCalendarSetAndGetVersion()
    {
        $version = '1.5';
        $cal = new qCal();
        $cal->addProperty('version', $version);
        $property = $cal->getProperty('version');
        $this->assertIsA($property, 'qCal_Property_version');
        $this->assertEqual($property->__toString(), $version);
        
        // test internal formatting
        $cal2 = new qCal();
        $cal2->addProperty('version', 1);
        $this->assertEqual($cal2->getProperty('version')->__toString(), '1.0');
        
        $multiversion = '1.25/2.0';
        $cal3 = new qCal();
        $cal3->addProperty('version', $multiversion);
        $this->assertEqual($cal3->getProperty('version')->__toString(), $multiversion);
        
        $invalidversion = '1.25/2.0-098P';
        $cal3 = new qCal();
        $cal3->addProperty('version', $invalidversion);
        $this->assertEqual($cal3->getProperty('version')->__toString(), '2.0'); // because lib defaults to 2.0
    }
    public function testCalendarSetAndGetProdid()
    {
        $prodid = 'I am a product id';
        $cal = new qCal();
        $cal->addProperty('prodid', $prodid);
        $property = $cal->getProperty('prodid');
        $this->assertIsA($property, 'qCal_Property_prodid');
        $this->assertEqual($property->__toString(), $prodid);
    }
}
/*
require_once 'qCal/iCal/Parser.php';
class TestOfqCaliCalendarParser extends UnitTestCase
{
    public function testSetAndGetRawData()
    {
        //$holidays = 'calendars/US Holidays.ics';
        //$parser = new qCal_iCal_Parser($holidays);
    }
}
*/
class TestOfProperties extends UnitTestCase
{
    public function testFactory()
    {
        $propertyname = 'prodid';
        $prodid = qCal_Property_Factory::createInstance($propertyname);
        $this->assertIsA($prodid, 'qCal_Property_Abstract');
    }
    /*public function testProdid()
    {
        $propertyname = 'prodid';
        $prodid = qCal_Property_Factory::createInstance($propertyname);
        $invalid_value = '';
    }*/
}

$test = new GroupTest('Core qCal Tests');
$test->addTestCase(new TestOfqCalCore);
//$test->addTestCase(new TestOfqCaliCalendarParser);
$test->addTestCase(new TestOfProperties);
$test->run(new HtmlReporter());