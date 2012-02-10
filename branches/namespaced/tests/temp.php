<?php
use qCal\DateTime;
use qCal\Date;
use qCal\Time;
use qCal\TimeZone;

$datetime = new DateTime; // Current time, current date, default timezone
$datetime = new DateTime(time()); // Does the same thing
$datetime = new DateTime(strtotime('2011-04-23T13:30:00Z')); // April 23rd, 2011 at 1:30pm Universal Time
$datetime = DateTime::generate('2011-04-23', '5:00pm', 'America/Los_Angeles'); // April 23rd at 5pm Pacific Standard Time
$datetime = DateTime::generate('2012-01-01'); // January 1st, 2012 at the current time in the default timezone
$datetime = DateTime::generate('2004'); // Current day and month, but in 2004 at the current time in the default timezone
$datetime = DateTime::generate('January 5th, 2004', '12pm', 'GMT'); // January 5th, 2004 at 12pm in Greenwich Mean Time
$datetime = DateTime::generate(new Date(), new Time(), new TimeZone()); // Current time and default timezone

$date = new Date; // Current date
$date = new Date(2012, 4, 23); // April 23rd, 2012
$date = new Date(2010); // Current date, but in 2010

$time = new Time; // Current time in default timezone
$time = new Time(10, 0, 0); // Ten o'clock in default timezone
$time = new Time(4, 30, 0); // Four thirty in default timezone
$time = new Time(4, 30, 0, 'GMT'); // 4:30 in GMT timezone
$time = new Time(12, 0, 0, 'America/Los_Angeles'); // Los Angeles timezone at noon

$tz = new TimeZone('America/Los_Angeles');
$tz = new TimeZone('GMT');
$tz = new TimeZone('-8'); // Pacific