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

require_once 'UnitTestCases/TestOfqCalCore.php';

$test = new GroupTest('Core qCal Tests');
$test->addTestCase(new TestOfqCalCore);
$test->run(new HtmlReporter());