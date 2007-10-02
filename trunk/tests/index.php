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

require_once 'qCal.php';

// used for debugging in html
function d($value)
{
    echo '<pre>';
    echo var_dump($value);
    echo '</pre>';
}

class TestOfqCalCore extends UnitTestCase
{
    public function testCalendarSetAndGetVersion()
    {
        $version = '2.0';
        $cal = new qCal();
        $cal->addProperty('version', $version);
        $property = $cal->getProperty('version');
        $this->assertIsA($property, 'qCal_Property_Abstract');
        $this->assertEqual($property->__toString(), $version);
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
require_once 'qCal/Component/Abstract.php';
require_once 'qCal/Property/Abstract.php';
require_once 'qCal/Property/Factory.php';
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