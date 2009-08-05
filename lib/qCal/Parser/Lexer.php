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
 */ 
class qCal_Parser_Lexer { // might make this abstract

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
        $this->content = $content;
    
    }
    /**
     * Return a list of tokens (to be fed to the parser)
     * @returns array tokens
     */
    public function tokenize() {
    
        // loop through chunks of input text by separating by properties and components
        // and create tokens for each one, creating a multi-dimensional array of tokens to return
        $lines = explode($this->line_terminator, $this->content);
        $stack = array();
        foreach ($lines as $line) {
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
        		if (preg_match('#^([a-z]+):([^\n]+)$#i', $line, $matches)) {
					$component =& $stack[count($stack)-1];
        			// if line is a property line, start a new property
					$proparray = array(
						'property' => $matches[1],
						'value' => $matches[2],
					);
        			$component['properties'][] = $proparray;
        		} elseif (preg_match('#^\w(.+)$#', $line, $matches)) {
        			// if it is a continuation of a line, continue the last property
        			$proparray['value'] .= $matches[1];
        		}
        	}
        }
        return $tokens;
    
    }

}