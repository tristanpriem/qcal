<?php
ini_set('display_errors', 'on');
error_reporting(E_ALL & ~E_DEPRECATED);

set_include_path('../lib' . PATH_SEPARATOR . get_include_path());

/**
 * @todo I need to figure out how to autoload these properly
 */
require_once 'functions.php';
require_once 'qCal.php';
require_once 'qCal/DateTime/Base.php';
require_once 'qCal/DateTime/Timezone.php';
require_once 'qCal/DateTime/Time.php';
require_once 'qCal/DateTime/Date.php';
require_once 'qCal/DateTime/DateTime.php';
require_once 'qCal/DateTime/Duration.php';
require_once 'qCal/DateTime/Period.php';

// include simpletest classes
require_once 'simpletest/unit_tester.php';
require_once 'simpletest/reporter.php';
require_once 'simpletest/mock_objects.php';

function __autoload($className) {

    $classPath = str_replace('_', DIRECTORY_SEPARATOR, $className);
    $paths = explode(PATH_SEPARATOR, get_include_path());
    foreach ($paths as $path) {
        $fullClassPath = $path . DIRECTORY_SEPARATOR . $classPath . '.php';
        if (file_exists($fullClassPath)) {
            require_once $fullClassPath;
            return true;
        }
    }
    return false;

}

require_once 'UnitTestCase/DateTime.php';
require_once 'UnitTestCase/DateTime/TimeZone.php';

// run tests in html reporter
$test = new GroupTest(/*qCal::getVersion . */'qCal Library Tests');
$test->addTestCase(new \UnitTestCase_DateTime_TimeZone);
$test->addTestCase(new \UnitTestCase_DateTime_Date);
$test->addTestCase(new \UnitTestCase_DateTime_Time);
$test->addTestCase(new \UnitTestCase_DateTime_DateTime);
$test->addTestCase(new \UnitTestCase_DateTime_Duration);
$test->addTestCase(new \UnitTestCase_DateTime_Period);

if (TextReporter::inCli()) {
    exit ($test->run(new TextReporter()) ? 0 : 1);
}
$test->run(new HtmlReporter());
