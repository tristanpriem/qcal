<?php
// define path to simpletest here
define('SIMPLETEST_PATH', realpath('./simpletest'));
define('QCAL_PATH', realpath('../lib'));
define('TESTCASE_PATH', realpath('../tests'));
define('TESTFILE_PATH', realpath('../tests/files'));
define('TESTCLASS_PATH', realpath('../tests/testclasses'));
// establish include path
set_include_path(
    SIMPLETEST_PATH . PATH_SEPARATOR .
    QCAL_PATH . PATH_SEPARATOR .
    TESTCASE_PATH . PATH_SEPARATOR .
	TESTCLASS_PATH . PATH_SEPARATOR . 
    get_include_path()
);
// require convenience functions
require_once 'convenience.php';
// require necessary simpletest files
require_once 'simpletest/unit_tester.php';
require_once 'simpletest/reporter.php';
require_once 'simpletest/mock_objects.php';

// create mocks
//Mock::generate('qCal_Component');
//Mock::generate('qCal_Property');
//Mock::generate('qCal_Renderer');
//Mock::generate('qCal_Parser');
//Mock::generate('qCal_Value_Multi');
// add tests cases to group and run the tests
$test = new GroupTest('Core qCal Tests');
// $test = new GroupTest('&nbsp;');
$test->addTestCase(new UnitTestCase_Parser);
$test->addTestCase(new UnitTestCase_Component);
$test->addTestCase(new UnitTestCase_Component_Alarm);
$test->addTestCase(new UnitTestCase_Component_Calendar);
$test->addTestCase(new UnitTestCase_Component_Timezone);
$test->addTestCase(new UnitTestCase_Component_Event);
$test->addTestCase(new UnitTestCase_Property);
$test->addTestCase(new UnitTestCase_Value);
$test->addTestCase(new UnitTestCase_Value_Date);
$test->addTestCase(new UnitTestCase_Value_Recur);
$test->addTestCase(new UnitTestCase_Value_Multi);
$test->addTestCase(new UnitTestCase_Renderer);
$test->addTestCase(new UnitTestCase_DateTimeV2);
$test->addTestCase(new UnitTestCase_DateV2);
$test->addTestCase(new UnitTestCase_Timezone);
$test->addTestCase(new UnitTestCase_Time);
$test->addTestCase(new UnitTestCase_Recur);
// $test->addTestCase(new UnitTestCase_Database);
$test->run(new HtmlReporter());