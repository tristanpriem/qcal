<?php
/**
 * Base property parameter class
 * @package qCal
 * @copyright Luke Visinoni (luke.visinoni@gmail.com)
 * @author Luke Visinoni (luke.visinoni@gmail.com)
 * @license GNU Lesser General Public License
 * 
 * RFC 2445 Definition
 * 
 * A property can have attributes associated with it. These "property
 * parameters" contain meta-information about the property or the
 * property value. Property parameters are provided to specify such
 * information as the location of an alternate text representation for a
 * property value, the language of a text property value, the data type
 * of the property value and other attributes.
 * 
 * Property parameter values that contain the COLON (US-ASCII decimal
 * 58), SEMICOLON (US-ASCII decimal 59) or COMMA (US-ASCII decimal 44)
 * character separators MUST be specified as quoted-string text values.
 * Property parameter values MUST NOT contain the DOUBLE-QUOTE (US-ASCII
 * decimal 22) character. The DOUBLE-QUOTE (US-ASCII decimal 22)
 * character is used as a delimiter for parameter values that contain
 * restricted characters or URI text. For example:
 * 
 *   DESCRIPTION;ALTREP="http://www.wiz.org":The Fall'98 Wild Wizards
 *     Conference - - Las Vegas, NV, USA
 * 
 * Property parameter values that are not in quoted strings are case
 * insensitive.
 * 
 * The general property parameters defined by this memo are defined by
 * the following notation:
 * 
 *   parameter  = altrepparam           ; Alternate text representation
 *              / cnparam               ; Common name
 *              / cutypeparam           ; Calendar user type
 *              / delfromparam          ; Delegator
 *              / deltoparam            ; Delegatee
 *              / dirparam              ; Directory entry
 *              / encodingparam         ; Inline encoding
 *              / fmttypeparam          ; Format type
 *              / fbtypeparam           ; Free/busy time type
 *              / languageparam         ; Language for text
 *              / memberparam           ; Group or list membership
 *              / partstatparam         ; Participation status
 *              / rangeparam            ; Recurrence identifier range
 *              / trigrelparam          ; Alarm trigger relationship
 *              / reltypeparam          ; Relationship type
 *              / roleparam             ; Participation role
 *              / rsvpparam             ; RSVP expectation
 *              / sentbyparam           ; Sent by
 *              / tzidparam             ; Reference to time zone object
 *              / valuetypeparam        ; Property value data type
 *              / ianaparam
 *      ; Some other IANA registered iCalendar parameter.
 *              / xparam
 *      ; A non-standard, experimental parameter.
 * 
 *   ianaparam  = iana-token "=" param-value *("," param-value)
 * 
 *   xparam     =x-name "=" param-value *("," param-value)
 */
class qCal_Parameter {

	/**
	 * @param string The parameter's name
	 */
	protected $name;
	/**
	 * @param string The parameter's value
	 */
	protected $value;
	/**
	 * @param array A list of properties this parameter is allowed to be specified for
	 */
	protected $allowedProperties = array();

}