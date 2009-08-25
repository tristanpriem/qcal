<?php
/**
 * This is a class that is used within qCal_Value_Recur to internally store a recur property
 * @todo The RFC says that invalid byXXX rule parts should simply be ignored. So I'm not sure if
 * I should be hurling exceptions at the poor user all over the place like I am in here.
 */
class qCal_Date_Recur {

	/**
	 * @var qCal_Date The start date/time of the recurrence
	 */
	protected $dtstart;
	/**
	 * @var string frequency of the recurrence
	 */
	protected $freq;
	/**
	 * @var array Allowed frequencies
	 */
	protected $freqtypes = array(
		'SECONDLY',
		'MINUTELY',
		'HOURLY',
		'DAILY',
		'WEEKLY',
		'MONTHLY',
		'YEARLY',
	);
	/**
	 * @var qCal_Date The date/time which the recurrence ends
	 */
	protected $until;
	/**
	 * @var integer The amount of recurrences
	 */
	protected $count;
	/**
	 * @var integer Interval of recurrence (for every 3 days, "3" would be the interval)
	 */
	protected $interval;
	/**
	 * @var integer|array An integer between 0 and 59 (for multiple, set as an array)
	 */
	protected $bysecond;
	/**
	 * @var integer|array An integer between 0 and 59 (or an array of integers for multiple)
	 */
	protected $byminute;
	/**
	 * @var integer|array An integer or array of integers between 0 and 23
	 */
	protected $byhour;
	/**
	 * @var string If present, represents the nth occurrence of a specific day within monthly or yearly
	 * so it can be something like +1MO (or simply 1MO) for the first monday within the month, whereas
	 * -1MO for the last monday of the month. Or it can be simply MO to represent every monday within the month
	 */
	protected $byday;
	/**
	 * @var integer|array An integer or array of integers. -31 to -1 or 1 to 31. -10 would mean the tenth to last
	 * day of the month. [1,5,-5] would be the 1st, 5th, and 5th to last days of the month
	 */
	protected $bymonthday;
	/**
	 * @var integer|array An integer or array of integers. -366 to -1 or 1 to 366. -306 represents the 306th to last
	 * day of the year (March 1st)
	 */
	protected $byyearday;
	/**
	 * @var integer|array An integer or array of integers. -53 to -1 or 1 to 53. Only valid for yearly rules. 
	 * 3 represents the third week of the year.
	 */
	protected $byweekno;
	/**
	 * @var integer|array An integer or array of integers. 1 to 12. 3 would represent March
	 */
	protected $bymonth;
	/**
	 * @var integer If present, it indicates the nth occurrence of the specific occurrence within the set of 
	 * events specified by this recurrence rule
	 */
	protected $bysetpos;
	/**
	 * @var string Must be one of the weekdays specified below (2 char). Specifies the day on which the work week
	 * starts. This is significant when a weekly rule has an interval greater than 1 and a byday rule part is specified.
	 * This is also significant when in a yearly rule when a byweekno rule part is specified. Defaults to "MO"
	 */
	protected $wkst = "MO";
	/**
	 * @var array An array of week days. Used throughout this class to validate input.
	 */
	protected $weekdays = array(
		'MO' => 'Monday',
		'TU' => 'Tuesday',
		'WE' => 'Wednesday',
		'TH' => 'Thursday',
		'FR' => 'Friday',
		'SA' => 'Saturday',
		'SU' => 'Sunday'
	);
	/**
	 * Constructor
	 * @param $freq string Must be one of the freqtypes specified above.
	 * @throws qCal_Date_Exception_InvalidRecur if a frequency other than those specified above is passed in
	 */
	public function __construct($freq, $dtstart = null) {
	
		$this->dtstart = is_null($dtstart) ? null : new qCal_Date($dtstart);
		$freq = strtoupper($freq);
		if (!in_array($freq, $this->freqtypes)) {
			throw new qCal_Date_Exception_InvalidRecur('"' . $freq . '" is not a valid frequency, must be one of the following: ' . implode(', ', $this->freqtypes));
		}
		$this->freq = $freq;
	
	}
	/**
	 * Specifies the date when the recurrence stops, inclusively. If not present, and there is no count specified,
	 * then the recurrence goes on "forever".
	 * @param $until string|qCal_Date|DateTime If time is specified, it must be UTC
	 * @throws qCal_Date_Exception_InvalidRecur
	 * @return self
	 */
	public function until($until) {
	
		$this->until = new qCal_Date($until);
		return $this;
	
	}
	/**
	 * Specifies the amount of recurrences before the recurrence ends. If neither this nor "until" is specified,
	 * the recurrence repeats "forever".
	 * @param $count integer The amount of recurrences before it stops
	 * @throws qCal_Date_Exception_InvalidRecur
	 * @return self
	 */
	public function count($count) {
	
		$this->count = (integer) $count;
		return $this;
	
	}
	/**
	 * Specifies the interval of recurrences
	 * @param $interval integer The interval of recurrences, for instance every "3" days
	 * @throws qCal_Date_Exception_InvalidRecur
	 * @return self
	 */
	public function interval($interval) {
	
		$this->interval = (integer) $interval;
		return $this;
	
	}
	/**
	 * Specifies a rule which will happen on every nth second. 
	 * @param $second integer|array Can be an integer (or array of ints) between 0 and 59
	 * @throws qCal_Date_Exception_InvalidRecur
	 * @return self
	 */
	public function bySecond($second) {
	
		if (!is_array($second)) $second = array($second);
		$this->bysecond = $second;
		return $this;
	
	}
	/**
	 * Specifies a rule which will happen on every nth minute
	 * @param $minute integer|array Can be an integer (or array of ints) between 0 and 59
	 * @throws qCal_Date_Exception_InvalidRecur
	 * @return self
	 */
	public function byMinute($minute) {
	
		if (!is_array($minute)) $minute = array($minute);
		$this->byminute = $minute;
		return $this;
	
	}
	/**
	 * Specifies a rule which will happen on every nth hour
	 * @param $hour integer|array Can be an integer (or array of ints) between 0 and 23
	 * @throws qCal_Date_Exception_InvalidRecur
	 * @return self
	 */
	public function byHour($hour) {
	
		if (!is_array($hour)) $hour = array($hour);
		$this->byhour = $hour;
		return $this;
	
	}
	/**
	 * Specifies a rule which will happen on whichever day is specified. For instance, "MO" would
	 * mean every monday.
	 * @param $day string|array Must be one of the 2-char week days specified above. Can be preceded by
	 * a positive or negative integer to represent, for instance, the third monday of the month (3MO) or second to last
	 * Sunday of the month (-2SU)
	 * @throws qCal_Date_Exception_InvalidRecur
	 * @return self
	 */
	public function byDay($day) {
	
		if (!is_array($day)) $day = array($day);
		$this->byday = $day;
		return $this;
	
	}
	/**
	 * Specifies a rule which will happen on the month days specified. For instance, 23 would mean the 23rd of every month.
	 * @param integer|array Must be between 1 and 31 or -31 to 1 (or an array of those values)
	 * @throws qCal_Date_Exception_InvalidRecur
	 * @return self
	 */
	public function byMonthDay($monthday) {
	
		if (!is_array($monthday)) $monthday = array($monthday);
		$this->bymonthday = $monthday;
		return $this;
	
	}
	/**
	 * Specifies a rule which will happen on the nth day of the year
	 * @param integer|array Must be between 1 and 366 or -366 to -1.
	 * @throws qCal_Date_Exception_InvalidRecur
	 * @return self
	 */
	public function byYearDay($yearday) {
	
		if (!is_array($yearday)) $yearday = array($yearday);
		$this->byyearday = $yearday;
		return $this;
	
	}
	/**
	 * Specifies a rule which will happen on the nth week of the year
	 * @param integer|array Must be between 1 and 53 or -53 to -1.
	 * @throws qCal_Date_Exception_InvalidRecur
	 * @return self
	 */
	public function byWeekNo($weekno) {
	
		if (!is_array($weekno)) $weekno = array($weekno);
		$this->byweekno = $weekno;
		return $this;
	
	}
	/**
	 * Specifies a rule which will happen on the nth month of the year
	 * @param integer|array Must be between 1 and 12
	 * @throws qCal_Date_Exception_InvalidRecur
	 * @return self
	 */
	public function byMonth($month) {
	
		if (!is_array($month)) $month = array($month);
		$this->bymonth = $month;
		return $this;
	
	}
	/**
	 * Indicates the nth occurrence of the specific occurrence within the set of
	 * events specified by the rule.
	 * @todo I don't really understand how this works... :( Figure out wtf it is for.
	 * @throws qCal_Date_Exception_InvalidRecur
	 * @return self
	 */
	public function bySetPos($setpos) {
	
		$this->bysetpos = (integer) $setpos;
		return $this;
	
	}
	/**
	 * Fetches instances of the recurrence rule in the given time period. Because recurrences
	 * could potentially go on forever, there is no way to fetch ALL instances of a recurrence rule
	 * other than providing a date range that spans the entire length of the recurrence.
	 * @todo This is really really really fuckin hard...
	 * @throws qCal_Date_Exception_InvalidRecur
	 */
	public function getInstances($start, $end) {
	
		$start = new qCal_Date($start);
		$end = new qCal_Date($end);
		if ($start->time() > $end->time()) throw new qCal_Date_Exception_InvalidRecur('Start date must come before end date');
		if (!$this->interval) throw new qCal_Date_Exception_InvalidRecur('You must specify an interval');
		// now we need to apply each byXXX rule to get the recurrence...
		if ($this->bymonth) {
			// find the first occurrence of the specified month and set that as the first occurence?
		}
		if ($this->byweekno) {
			
		}
		if ($this->byyearday) {
			
		}
		if ($this->bymonthday) {
			
		}
		if ($this->byday) {
			
		}
		if ($this->byhour) {
			
		}
		if ($this->byminute) {
			
		}
		if ($this->bysecond) {
			
		}
		if ($this->bysetpos) {
			
		}
		// after all of the above (in this exact order), cound and until are evaluated
	
	}

}