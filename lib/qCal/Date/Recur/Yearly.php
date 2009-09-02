<?php
class qCal_Date_Recur_Yearly extends qCal_Date_Recur {

	protected function doGetRecurrences($start, $end) {
	
		$rules = array(
			'bymonth' => array(),
			'byweekno' => array(),
			'byyearday' => array(),
			'byday' => array(),
		);
		
		// byMonth rules
		if (is_array($this->bymonth)) {
			foreach ($this->bymonth as $bymonth) {
				$rules['bymonth'][] = new qCal_Date_Recur_Rule_ByMonth($bymonth);
			}
		}
		
		// byWeekNo rules
		if (is_array($this->byweekno)) {
			foreach ($this->byweekno as $byweekno) {
				$rules['byweekno'][] = new qCal_Date_Recur_Rule_ByWeekNo($byweekno);
			}
		}
		
		// byYearDay rules
		if (is_array($this->byyearday)) {
			foreach ($this->byyearday as $byyearday) {
				$rules['byyearday'][] = new qCal_Date_Recur_Rule_ByYearDay($byyearday);
			}
		}
		
		// byMonthDay rules (these get applied to bymonth rules)
		if (is_array($this->bymonthday)) {
			foreach ($this->bymonthday as $bymonthday) {
				$bmdrule = new qCal_Date_Recur_Rule_ByMonthDay($bymonthday);
				foreach ($rules['bymonth'] as $bymonth) {
					$bymonth->attach($bmdrule);
				}
			}
		}
		
		// byDay rules (these get applied to bymonth rules if they exist, otherwise simply to year)
		if (is_array($this->byday)) {
			foreach ($this->byday as $byday) {
				$bdrule = new qCal_Date_Recur_Rule_ByDay($byday);
				if (is_array($rules['bymonth']) && !empty($rules['bymonth'])) {
					foreach ($rules['bymonth'] as $bymonth) {
						$bymonth->attach($bdrule);
					}
				} else {
					$rules['byday'][] = $bdrule;
				}
			}
		}
		
		// byHour rules (these get applied to each rule above)
		if (is_array($this->byhour)) {
			foreach ($this->byhour as $byhour) {
				$bhrule = new qCal_Date_Recur_Rule_ByHour($byhour);
				foreach ($rules as $type => $ruleset) {
					foreach ($ruleset as $rule) {
						$rule->attach($bhrule);
					}
				}
			}
		}
		
		// byMinute rules (these get applied to each rule above)
		if (is_array($this->byminute)) {
			foreach ($this->byminute as $byminute) {
				$bmrule = new qCal_Date_Recur_Rule_ByMinute($byminute);
				foreach ($rules as $type => $ruleset) {
					foreach ($ruleset as $rule) {
						$rule->attach($bmrule);
					}
				}
			}
		}
		
		// bySecond rules (these get applied to each rule above)
		if (is_array($this->bysecond)) {
			foreach ($this->bysecond as $bysecond) {
				$bsrule = new qCal_Date_Recur_Rule_BySecond($bysecond);
				foreach ($rules as $type => $ruleset) {
					foreach ($ruleset as $rule) {
						$rule->attach($bsrule);
					}
				}
			}
		}
		
		// @todo bySetPos (this fetches certain recurrences from the final set)
		
		// now go over each rule and evaluate them out to real dates
		
		// for bymonth, it would make the most sense to loop over each month until the specified one
		// is found. Then loop over each day to find its sub-rules.
		
		// for byweekno, it would make the most sense to loop over each week until the specified one
		// is found. Then apply any sub-rules (actually I'm not sure how byhour and its ilk would be applied in this situation... need to read the rfc)
	
	}

}