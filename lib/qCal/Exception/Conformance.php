<?php
/**
 * Conformance Exception
 * When qCal encounters a situation that is not in conformence RFC 2445
 * it throws a qCal_Exception_Conformence exception. For example, if a
 * user attempts to set the prodid property on a VEVENT component, that is
 * in violation of RFC 2445 and will trigger a conformence exception. The
 * user will eventually have options as to what to do in the case of this
 * exception, but for now the library will simply catch the exception
 * and log the violation in the internal logger (most likely something
 * like qCal_Log, but I'm not sure yet).
 * 
 * After using this a little bit, I'm discovering that I probably can't
 * use it how I had intended, so I'm going to rethink the exception scheme
 * a bit.
 * 
 * @package qCal
 * @copyright Luke Visinoni (luke.visinoni@gmail.com)
 * @author Luke Visinoni (luke.visinoni@gmail.com)
 * @license GNU Lesser General Public License
 */
class qCal_Exception_Conformance extends qCal_Exception {

	

}