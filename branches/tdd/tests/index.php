<?php

set_include_path(
    //'\\\\Mc2-server\\Software Downloads\\PHP Libs' . PATH_SEPARATOR .
    //'\\\\Mc2-server\\Projects\\MC2 Design\\002967_qCal_ Library_and_App\\Web_Build\\lib' . PATH_SEPARATOR .
    'C:\\htdocs\\qcal-rewrite\\lib' . PATH_SEPARATOR .
    'C:\\phplib' . PATH_SEPARATOR .
    'C:\\htdocs\\library' . PATH_SEPARATOR .
    // add simpletest directory here
    get_include_path()
);

require_once 'simpletest/unit_tester.php';
require_once 'simpletest/reporter.php';
require_once 'simpletest/mock_objects.php';

require_once 'qCal.php';
require_once 'qCal/Component.php';
require_once 'qCal/Exception.php';

Mock::generate('qCal_Component', 'Mock_qCal_Component');
Mock::generate('qCal_Attachable', 'Mock_qCal_Attachable');

//require_once 'qCal/Property/MultipleValue.php';

class Test_Of_qCal_Component extends UnitTestCase
{
    public function test_qCal_Component_Is_Attachable()
    {
        $calendar = new Mock_qCal_Component;
        $this->assertTrue($calendar instanceof qCal_Attachable);
    }
    
    public function test_qCal_Cannot_Be_Instantiated()
    {
        $this->expectException(new qCal_Exception('qCal cannot be instantiated. Use qCal::create()'));
        $calendar = new qCal();
    }
    
    public function test_Create_qCal_Component_vcalendar()
    {
        $calendar = qCal::create();
        $this->assertTrue($calendar instanceof qCal_Component_vcalendar);
    }
}

$test = new GroupTest('Core qCal Tests');
$test->addTestCase(new Test_Of_qCal_Component);
$test->run(new HtmlReporter());