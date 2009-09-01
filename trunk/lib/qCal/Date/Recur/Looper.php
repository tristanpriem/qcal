<?php
abstract class qCal_Date_Recur_Looper {

	static public function factory($type) {
	
		$type = ucfirst(strtolower($type));
		$className = 'qCal_Date_Recur_Looper_' . $type;
		$fileName = str_replace("_", DIRECTORY_SEPARATOR, $className) . ".php";
		qCal_Loader::loadFile($fileName);
		return new $className();
	
	}

}