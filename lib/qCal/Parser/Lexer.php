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
        	if (strpos($line, "BEGIN:") === 0) {
        		// create a new array to hold info about this component
        		$array = array();
        		// make a reference to it on the top of the stack (not sure if the amp is necessary
        		// does php pass make a reference automatically here or does it copy?
        		$stack[] =& $array;
        	// end a component
        	} elseif (strpos($line, "END:") === 0) {
        		$array = array_pop($stack);
        	// not beginning or ending component
        	} else {
        		
        	}
        }
        return array();
    
    }
    /**
     * Creates a token from a string (chunk of content)
     * @returns qCal_Parser_Token
     */
    public function createToken($string) {
    
        return new qCal_Parser_Token($string);
    
    }

}