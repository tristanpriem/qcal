<?php
/**
 * Global Functions
 * Put any global functions in this file - as a general rule, global functions are discouraged,
 * but sometimes it's nice to simply be able to call a short function for things like debugging
 *
 * @version $Id: functions.php 75 2010-04-04 16:58:15Z luke $
 * @todo Add a varlog function
 */

/**
 * Basically an alias to var_dump, except that it is shorter and inside of pre tags
 * @todo This should only work in development mode
 */
function pr($input, $return = false) {

    ob_start();
    echo "<pre>\n";
    var_dump($input);
    echo "</pre>\n";
    $output = ob_get_clean();
    if ($return) return $output;
    print $output;

}

/**
 * Does the same thing as pr() but exports dump as php code instead
 */
function prx($input, $return = false) {

    ob_start();
    echo "<pre>\n";
    var_export($input);
    echo "</pre>\n";
    $output = ob_get_clean();
    if ($return) return $output;
    print $output;

}

function pre($input) {

    exit(pr($input, true));

}

function get_digits($input) {

    return preg_replace('/[^0-9]/', '', $input);

}

function get_alpha($input) {

    return preg_replace('/[^a-z]/i', '', $input);

}

function get_alnum($input) {

    return preg_replace('/[^a-z0-9]/i', '', $input);

}
/**
 * Get the column from an array. Basically, this searches an
 * array for $column as a key and returns any values in the array
 * that has that key.
 * This only really works with a two-dimansional array. For isntance:
 * id,	name,	is_active
 * 1	Bobby	1
 * 2	Ralph	0
 * 3	John	1
 * In that kind of array, you could specify "name" as the column and get
 * back Bobby, Ralph and John in an array.
 * @todo Test this out thoroughly. 
 */
function array_column($array, $column) {

	$return = array();
	foreach ($array as $key => $value) {
		if (is_array($value) && array_key_exists($column, $value)) {
			$return[] = $value[$column];
		}
	}
	return $return;

}

if (!function_exists('_')) {
	/**
	 * Translate
	 * Eventually this function will grab the translate object from the registry
	 * and do a translation if necessary, but for now it just returns the string.
	 * That way I can ready the application for translation without having to
	 * actually do anything yet.
	 */
	function _($str) {
	
		try {
			$translate = Zend_Registry::get('Zend_Translate');
			$str = $translate->_($str);
		} catch (Exception $e) {
			// do nothing
			// apparently _() doesn't throw an exception when a string isn't found... there is a notice instead... grr...
			// need to figure this out...
		}
		return $str;
	
	}
}
