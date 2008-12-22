<?php
class qCal_DateTime {

	/**
	 * Contains array with 4-digit year, 2-digit month, 2-digit day, 2-digit hour
	 * 2-digit minute, and 2-digit second
	 */
	protected $value = array(
		'year' => null,
		'month' => null,
		'day' => null,
		'hour' => null,
		'minute' => null,
		'second' => null,
		'timezone' => null
	);
	
	public function __construct($date = null) {
	
		if (is_null($date)) {
			$date = time();
		}
		if (!ctype_digit($date)) $date = strtotime($date);
		$datetime = getdate($date);
		$this->value = array(
			'year' => $datetime['year'],
			'month' => $datetime['mon'],
			'day' => $datetime['mday'],
			'hour' => $datetime['hours'],
			'minute' => $datetime['minutes'],
			'second' => $datetime['seconds'],
			'timezone' => null
		);
	
	}
	
	public function toUnixTimestamp() {
	
		return mktime(
			$this->value['hour'],
			$this->value['minute'],
			$this->value['second'],
			$this->value['month'],
			$this->value['day'],
			$this->value['year']
		);
	
	}

}