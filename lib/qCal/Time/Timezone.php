<?php
class qCal_Time_Timezone {

	public function __construct($timezone = null) {
	
		if (!is_null($timezone)) {
			date_default_timezone_set($timezone);
		}
	
	}
	
	public function getOffsetSeconds() {
	
		return date("Z");
	
	}
	
	public function getOffsetHours() {
	
		return date("O");
	
	}
	
	public function getOffset() {
	
		return date("P");
	
	}
	
	public function getAbbreviation() {
	
		return date("T");
	
	}
	
	public function isDaylightSavings() {
	
		return (boolean) date("I");
	
	}
	
	public function getName() {
	
		return date("e");
	
	}

}