<?php
/**
 * Yearly Date/Time Recurrence object.
 * This class is used to create recurrence rules that happen on a yearly basis.
 * 
 * @package qCal
 * @subpackage qCal_DateTime_Recur
 * @copyright Luke Visinoni (luke.visinoni@gmail.com)
 * @author Luke Visinoni (luke.visinoni@gmail.com)
 * @license GNU Lesser General Public License
 */
class qCal_DateTime_Recur_Yearly extends qCal_DateTime_Recur {

	protected function init() {
	
		// make a copy of the start date/time to work with
		$start = $this->start;
	
	}

}