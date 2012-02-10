<?php
/**
 * qCal\Time and qCal\TimeZone Use Cases
 * Time and timezone are pretty closely related, so I'll put their use cases in
 * one single file. You cannot use qCal\Time without qCal\Timezone so whether or
 * not you know it, if you're using qCal\Time, you're using qCal\Timezone.
 *
 * The qCal\Time class is pretty skimpy because it actually isn't all that
 * important. It is simply for representing times that don't have an associated
 * date within qCal. Generally, the more useful time class is DateTime, which is
 * what is use for a particular point in time, rather than simply a time on no
 * particular day.
 */

use qCal\DateTime;
use qCal\TimeZone;
use qCal\Time;

/**
 * Before using qCal\Time or qCal\Timezone, or anything from qCal for that
 * matter, you need to set the default timezone
 */
date_default_timezone_set('America/Los_Angeles');

/**
 * Creating and setting times
 */
$time = new Time; // defaults to current time
$time->set('4:30pm'); // need to determine what format(s) this supports
$time->setHour(4, Time::PM); // Sets to 4pm, the second argument allows for non-military time
$time->setHour(4); // Sets to 4am (AM is default)
$time->setMinute(30);
$time->setSecond(15);

/**
 * Getting time information
 */
$time->getHour();
$time->getMinute();
$time->getSecond();

/**
 * Difference between times
 */
$diff = $time->diff($othertime, Time::HOURS); // difference in hours
$diff = $time->diff($othertime, Time::SECONDS); // difference in seconds

/**
 * Convenience Methods
 */
$time->isNow();
$time->isHour(); // true if time is the current hour, or, $time->isHour($othertime) for testing against a particular time
$time->isMinute(); // true if time is the current minute
$time->isSecond(); // true if time is the current second
$time->isAfter($othertime);
$time->isBefore($othertime);
$time->isEqualTo($othertime);

/**
 * Timezones
 */
$tz = new TimeZone; // defaults to default timezone above (America/Los_Angeles)
$tz = new TimeZone('America/New_York');
$tz->set('America/New_York');
$tz->set('GMT'); // Can also use three character timezone names
$tz->set('PST');
$tz->set('UTC'); // Universal time

/**
 * Using timezones with times
 */
$time = new Time('6:00am'); // uses server's default timezone
echo $time->toString('g:ia'); // outputs 6:00am
echo $time->toString('g:ia T'); // outputs 6:00am PST
$time->setTimezone($tz); // now using UTC
echo $time->toString('g:ia'); // now outputs 2:00pm

/**
 * Some examples of ways the time object is used (with timezones)
 */
// Set time in YOUR timezone and find out what time it is in another
$time = new Time('5:00pm');
echo $time->toString('g:ia', $tz);
// or...
$time->setTimezone($tz);
echo $time->toString('g:ia');

/**
 * DateTime
 * Although there are a lot of uses for the Time object in qCal, the more
 * general-purpose class is DateTime, which represents a time on a specific date
 */
$dt = new DateTime('2005-04-23 5:00pm'); // April 23rd, 2005 at 5:00pm in America/Los_Angeles
$tz = new TimeZone('Europe/London'); // GMT time
$dt->setTimezone($tz);
echo $dt->toString('m-d-Y \a\t g:ia T'); // Outputs 4-24-2005 at 2:00am GMT
echo $dt->toString('m-d-Y \a\t g:ia T', new TimeZone('UTC')); // Outputs the same thing but with GMT instead of UTC (same date and time tho cuz they're basically the same)

