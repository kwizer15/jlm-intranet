<?php
namespace JLM\CoreBundle\DQL;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
/**
 * DateFunction ::= "DATE" "(" ArithmeticPrimary ")"
 */
class DateFunction extends FunctionNode
{
	// (1)
	public $expression = null;

	public function parse(\Doctrine\ORM\Query\Parser $parser)
	{
		$parser->match(Lexer::T_IDENTIFIER); // (2)
		$parser->match(Lexer::T_OPEN_PARENTHESIS); // (3)
		$this->expression = $parser->ArithmeticPrimary(); // (4)
		$parser->match(Lexer::T_CLOSE_PARENTHESIS); // (3)
	}

	public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
	{
		return 'DATE(' .
				$this->expression->dispatch($sqlWalker) . 
				')'; // (7)
	}
}
