<?php
/**
 * Value Name: FLOAT
 * 
 * Purpose: This value type is used to identify properties that contain
 * a real number value.
 * 
 * Formal Definition: The value type is defined by the following
 * notation:
 * 
 *  float      = (["+"] / "-") 1*DIGIT ["." 1*DIGIT]
 * 
 * Description: If the property permits, multiple "float" values are
 * specified by a COMMA character (US-ASCII decimal 44) separated list
 * of values.
 * 
 * No additional content value encoding (i.e., BACKSLASH character
 * encoding) is defined for this value type.
 * 
 * Example:
 * 
 *  1000000.0000001
 *  1.333
 *  -3.14
 */
class qCal_DataType_Float extends qCal_DataType {

	

}