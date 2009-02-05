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
class qCal_Parser_Lexer extends qCal_Parser {

    /**
     * @var string input text
     */
    protected $content;
    /**
     * Constructor
     * @param string containing the text to be tokenized
     */
    public function __construct($content) {
    
        $this->content = $content;
    
    }
    /**
     * Return a list of tokens (to be fed to the parser)
     * @returns array tokens
     */
    public function tokenize() {
    
        // loop through chunks of input text by separating by properties and components
        // and create tokens for each one, creating a multi-dimensional array of tokens to return
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