<?php
// require convenience functions
require_once 'convenience.php';
// define path to simpletest here
define('SIMPLETEST_PATH', realpath('./simpletest'));
define('QCAL_PATH', realpath('../'));
// establish include path
set_include_path(
    SIMPLETEST_PATH . PATH_SEPARATOR .
    QCAL_PATH . PATH_SEPARATOR .
    get_include_path()
);
// require necessary simpletest files
require_once 'unit_tester.php';
require_once 'reporter.php';
require_once 'mock_objects.php';
// require test cases
require_once 'UnitTestCases/TestParser.php';
// add tests cases to group and run the tests
$test = new GroupTest('Core qCal Tests');
$test->addTestCase(new TestParser);
$test->run(new HtmlReporter());
