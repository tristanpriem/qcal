<?php
/**
 * Calendar User Address Data Type 
 * @package qCal
 * @copyright Luke Visinoni (luke.visinoni@gmail.com)
 * @author Luke Visinoni (luke.visinoni@gmail.com)
 * @license GNU Lesser General Public License
 *
 * Value Name: CAL-ADDRESS
 * 
 * Purpose: This value type is used to identify properties that contain
 * a calendar user address.
 * 
 * Formal Definition: The value type is as defined by the following
 * notation:
 * 
 *  cal-address        = uri
 * 
 * Description: The value is a URI as defined by [RFC 1738] or any other
 * IANA registered form for a URI. When used to address an Internet
 * email transport address for a calendar user, the value MUST be a
 * MAILTO URI, as defined by [RFC 1738]. No additional content value
 * encoding (i.e., BACKSLASH character encoding) is defined for this
 * value type.
 * 
 * Example:
 * 
 *  ATTENDEE:MAILTO:jane_doe@host.com
 */
class qCal_DataType_CalAddress extends qCal_DataType_Uri {

	

}