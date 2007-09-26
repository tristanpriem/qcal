<?php

set_include_path(
    '\\\\Mc2-server\\Software Downloads\\PHP Libs' . PATH_SEPARATOR .
    '\\\\Mc2-server\\Projects\\MC2 Design\\002967_qCal_ Library_and_App\\Web_Build\\lib' . PATH_SEPARATOR .
    // add simpletest directory here
    get_include_path()
);

require_once 'simpletest/unit_tester.php';
require_once 'simpletest/reporter.php';

require_once 'qCal.php';

class TestOfqCalCore extends UnitTestCase
{
    public function testCalendarSetAndGetVersion()
    {
        $version = '2.0';
        $cal = new qCal();
        $cal->setProperty('version', $version);
        $this->assertIdentical($cal->getProperty('version'), $version);
    }
}

require_once 'qCal/iCal/Parser.php';
class TestOfqCaliCalendarParser extends UnitTestCase
{
    public function testSetAndGetRawData()
    {
        //$holidays = 'calendars/US Holidays.ics';
        //$parser = new qCal_iCal_Parser($holidays);
    }
}

$test = new GroupTest('Core qCal Tests');
$test->addTestCase(new TestOfqCalCore);
$test->addTestCase(new TestOfqCaliCalendarParser);
$test->run(new HtmlReporter());