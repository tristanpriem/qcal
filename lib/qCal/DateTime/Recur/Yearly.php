<?php
/**
 * Yearly rules should be fairly easy because we can start with every year
 * on the date that is passed to the constructor. Then for each type of byXXX
 * that is added, we simply add more dates (or keep the same amount) that will
 * be in the results. The exception is bySetPos, which will usually reduce the
 * amount of recurrences no matter what.
 */
class qCal_DateTime_Recur_Yearly extends qCal_DateTime_Recur {

	

}