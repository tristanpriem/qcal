<?php
// define path to simpletest here
define('SIMPLETEST_PATH', realpath('./simpletest'));
define('QCAL_PATH', realpath('../lib'));
define('TESTCASE_PATH', realpath('../tests'));
define('TESTFILE_PATH', realpath('../tests/files'));
// establish include path
set_include_path(
    SIMPLETEST_PATH . PATH_SEPARATOR .
    QCAL_PATH . PATH_SEPARATOR .
    TESTCASE_PATH . PATH_SEPARATOR .
    get_include_path()
);
// require convenience functions
require_once 'convenience.php';
// require necessary simpletest files
require_once 'unit_tester.php';
require_once 'reporter.php';
require_once 'mock_objects.php';
// require test cases
// require_once 'UnitTestCase/Parser.php';
// require_once 'UnitTestCase/Component.php';
// add tests cases to group and run the tests
$test = new GroupTest('Core qCal Tests');
$test->addTestCase(new UnitTestCase_Parser);
$test->addTestCase(new UnitTestCase_Component);
$test->addTestCase(new UnitTestCase_Property);
$test->run(new HtmlReporter());
