<?php
/**
 * qCal_Parser_Lexer
 * Not sure if I like the name of this class, but what can you do?
 * Anyway, this class converts a string into "tokens" which are then
 * fed to the parser
 * 
 * @package qCal
 * @subpackage qCal_Parser
 * @copyright Luke Visinoni (luke.visinoni@gmail.com)
 * @author Luke Visinoni (luke.visinoni@gmail.com)
 * @license GNU Lesser General Public License
 * @todo I believe this should probably be abstract and it should rely
 * on a child to do the actual parsing as this does.
 */ 
class qCal_Parser_Lexer {

	const FOLD_LENGTH = 75;
    /**
     * @var string input text
     */
    protected $content;
    /**
     * @var string character(s) used to terminate lines
     */
    protected $line_terminator;
    /**
     * Constructor
     * @param string containing the text to be tokenized
     */
    public function __construct($content) {
    
    	$this->line_terminator = chr(13) . chr(10);
        $this->content = $this->unfold($content);
		// pre($this->content);
    
    }
    /**
     * Return a list of tokens (to be fed to the parser)
     * @returns array tokens
     */
    public function tokenize() {
    
		$lines = $this->unfold($this->content);
        // loop through chunks of input text by separating by properties and components
        // and create tokens for each one, creating a multi-dimensional array of tokens to return
        $stack = array();
        foreach ($this->content as $line) {
        	// begin a component
        	if (preg_match('#^BEGIN:([a-z]+)$#i', $line, $matches)) {
        		// create new array representing the new component
        		$array = array(
        			'component' => $matches[1],
        			'properties' => array(),
        			'children' => array(),
        		);
        		$stack[] = $array;
        	} elseif (strpos($line, "END:") === 0) {
        		// end component, pop the stack
        		$child = array_pop($stack);
				if (empty($stack)) {
					$tokens = $child;
				} else {
					$parent =& $stack[count($stack)-1];
					array_push($parent['children'], $child);
				}
        	} else {
        		// continue component
        		if (preg_match('#^([a-z0-9;"=-]+):"?([^\n"]+)"?$#i', $line, $matches)) {
					$component =& $stack[count($stack)-1];
        			// if line is a property line, start a new property, but first determine if there are any params
					$property = $matches[1];
					$params = array();
					$propparts = explode(";", $matches[1]);
					if (count($propparts) > 1) {
						foreach ($propparts as $key => $part) {
							// the first one is the property name
							if ($key == 0) {
								$property = $part;
							} else {
								// the rest are params
								// @todo Quoted param values need to be taken care of...
								list($paramname, $paramvalue) = explode("=", $part, 2);
								$params[] = array(
									'param' => $paramname,
									'value' => $paramvalue,
								);
							}
						}
					}
					$proparray = array(
						'property' => $property,
						'value' => $matches[2],
						'params' => $params,
					);
        			$component['properties'][] = $proparray;
        		}
        	}
        }
        return $tokens;
    
    }
	/**
	 * Unfold the file before trying to parse it
	 */
	protected function unfold($content) {
	
		$return = array();
		$lines = explode($this->line_terminator, $content);
		foreach ($lines as $line) {
			$chr1 = substr($line, 0, 1);
			$therest = substr($line, 1);
			// if character 1 is a whitespace character... (tab or space)
			if ($chr1 == chr(9) || $chr1 == chr(32)) {
				$return[count($return)-1] .= $therest;
			} else {
				$return[] = $line;
			}
		}
		return $return;
	
	}

}