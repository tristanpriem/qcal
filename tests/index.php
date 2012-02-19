<?php
ini_set('display_errors', 'on');
error_reporting(E_ALL & ~E_DEPRECATED);

set_include_path('../lib' . PATH_SEPARATOR . get_include_path());

/**
 * @todo I need to figure out how to autoload these properly
 */
require_once 'functions.php';
require_once 'qCal.php';
require_once 'qCal/Humanize.php';
require_once 'qCal/DateTime/Base.php';
require_once 'qCal/DateTime/Timezone.php';
require_once 'qCal/DateTime/Time.php';
require_once 'qCal/DateTime/Date.php';
require_once 'qCal/DateTime/DateTime.php';
require_once 'qCal/DateTime/Duration.php';
require_once 'qCal/DateTime/Period.php';

require_once 'qCal/Recurrence/Pattern.php';
require_once 'qCal/Recurrence/Secondly.php';
require_once 'qCal/Recurrence/Minutely.php';
require_once 'qCal/Recurrence/Hourly.php';
require_once 'qCal/Recurrence/Daily.php';
require_once 'qCal/Recurrence/Weekly.php';
require_once 'qCal/Recurrence/Monthly.php';
require_once 'qCal/Recurrence/Yearly.php';

require_once 'qCal/Recurrence/Pattern/Rule.php';
require_once 'qCal/Recurrence/Pattern/BySecond.php';
require_once 'qCal/Recurrence/Pattern/ByMinute.php';
require_once 'qCal/Recurrence/Pattern/ByHour.php';
require_once 'qCal/Recurrence/Pattern/ByDay.php';
require_once 'qCal/Recurrence/Pattern/ByMonthDay.php';
require_once 'qCal/Recurrence/Pattern/ByYearDay.php';
require_once 'qCal/Recurrence/Pattern/ByMonth.php';
require_once 'qCal/Recurrence/Pattern/BySetPos.php';
require_once 'qCal/Recurrence/Pattern/ByWeekNo.php';

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

// run tests in html reporter
$test = new GroupTest(/*qCal::getVersion . */'qCal Library Tests');
$test->addTestCase(new \UnitTestCase_Humanize);
$test->addTestCase(new \UnitTestCase_DateTime_TimeZone);
$test->addTestCase(new \UnitTestCase_DateTime_Date);
$test->addTestCase(new \UnitTestCase_DateTime_Time);
$test->addTestCase(new \UnitTestCase_DateTime_DateTime);
$test->addTestCase(new \UnitTestCase_DateTime_Duration);
$test->addTestCase(new \UnitTestCase_DateTime_Period);
$test->addTestCase(new \UnitTestCase_Recurrence_Pattern);
$test->addTestCase(new \UnitTestCase_Recurrence_Yearly);
$test->addTestCase(new \UnitTestCase_Recurrence_Rule);

if (TextReporter::inCli()) {
    exit ($test->run(new TextReporter()) ? 0 : 1);
}
$test->run(new HtmlReporter());
