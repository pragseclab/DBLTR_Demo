<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Symfony\Component\ExpressionLanguage;

/**
 * Parsers a token stream.
 *
 * This parser implements a "Precedence climbing" algorithm.
 *
 * @see http://www.engr.mun.ca/~theo/Misc/exp_parsing.htm
 * @see http://en.wikipedia.org/wiki/Operator-precedence_parser
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Parser
{
    public const OPERATOR_LEFT = 1;
    public const OPERATOR_RIGHT = 2;
    private $stream;
    private $unaryOperators;
    private $binaryOperators;
    private $functions;
    private $names;
    public function __construct(array $functions)
    {
        $this->functions = $functions;
        $this->unaryOperators = ['not' => ['precedence' => 50], '!' => ['precedence' => 50], '-' => ['precedence' => 500], '+' => ['precedence' => 500]];
        $this->binaryOperators = ['or' => ['precedence' => 10, 'associativity' => self::OPERATOR_LEFT], '||' => ['precedence' => 10, 'associativity' => self::OPERATOR_LEFT], 'and' => ['precedence' => 15, 'associativity' => self::OPERATOR_LEFT], '&&' => ['precedence' => 15, 'associativity' => self::OPERATOR_LEFT], '|' => ['precedence' => 16, 'associativity' => self::OPERATOR_LEFT], '^' => ['precedence' => 17, 'associativity' => self::OPERATOR_LEFT], '&' => ['precedence' => 18, 'associativity' => self::OPERATOR_LEFT], '==' => ['precedence' => 20, 'associativity' => self::OPERATOR_LEFT], '===' => ['precedence' => 20, 'associativity' => self::OPERATOR_LEFT], '!=' => ['precedence' => 20, 'associativity' => self::OPERATOR_LEFT], '!==' => ['precedence' => 20, 'associativity' => self::OPERATOR_LEFT], '<' => ['precedence' => 20, 'associativity' => self::OPERATOR_LEFT], '>' => ['precedence' => 20, 'associativity' => self::OPERATOR_LEFT], '>=' => ['precedence' => 20, 'associativity' => self::OPERATOR_LEFT], '<=' => ['precedence' => 20, 'associativity' => self::OPERATOR_LEFT], 'not in' => ['precedence' => 20, 'associativity' => self::OPERATOR_LEFT], 'in' => ['precedence' => 20, 'associativity' => self::OPERATOR_LEFT], 'matches' => ['precedence' => 20, 'associativity' => self::OPERATOR_LEFT], '..' => ['precedence' => 25, 'associativity' => self::OPERATOR_LEFT], '+' => ['precedence' => 30, 'associativity' => self::OPERATOR_LEFT], '-' => ['precedence' => 30, 'associativity' => self::OPERATOR_LEFT], '~' => ['precedence' => 40, 'associativity' => self::OPERATOR_LEFT], '*' => ['precedence' => 60, 'associativity' => self::OPERATOR_LEFT], '/' => ['precedence' => 60, 'associativity' => self::OPERATOR_LEFT], '%' => ['precedence' => 60, 'associativity' => self::OPERATOR_LEFT], '**' => ['precedence' => 200, 'associativity' => self::OPERATOR_RIGHT]];
    }
    /**
     * Converts a token stream to a node tree.
     *
     * The valid names is an array where the values
     * are the names that the user can use in an expression.
     *
     * If the variable name in the compiled PHP code must be
     * different, define it as the key.
     *
     * For instance, ['this' => 'container'] means that the
     * variable 'container' can be used in the expression
     * but the compiled code will use 'this'.
     *
     * @param array $names An array of valid names
     *
     * @return Node\Node A node tree
     *
     * @throws SyntaxError
     */
    public function parse(TokenStream $stream, $names = [])
    {
        $this->stream = $stream;
        $this->names = $names;
        $node = $this->parseExpression();
        if (!$stream->isEOF()) {
            throw new SyntaxError(sprintf('Unexpected token "%s" of value "%s".', $stream->current->type, $stream->current->value), $stream->current->cursor, $stream->getExpression());
        }
        return $node;
    }
    public function parseExpression($precedence = 0)
    {
        $expr = $this->getPrimary();
        $token = $this->stream->current;
        while ($token->test(Token::OPERATOR_TYPE) && isset($this->binaryOperators[$token->value]) && $this->binaryOperators[$token->value]['precedence'] >= $precedence) {
            $op = $this->binaryOperators[$token->value];
            $this->stream->next();
            $expr1 = $this->parseExpression(self::OPERATOR_LEFT === $op['associativity'] ? $op['precedence'] + 1 : $op['precedence']);
            $expr = new Node\BinaryNode($token->value, $expr, $expr1);
            $token = $this->stream->current;
        }
        if (0 === $precedence) {
            return $this->parseConditionalExpression($expr);
        }
        return $expr;
    }
    protected function getPrimary()
    {
        $token = $this->stream->current;
        if ($token->test(Token::OPERATOR_TYPE) && isset($this->unaryOperators[$token->value])) {
            $operator = $this->unaryOperators[$token->value];
            $this->stream->next();
            $expr = $this->parseExpression($operator['precedence']);
            return $this->parsePostfixExpression(new Node\UnaryNode($token->value, $expr));
        }
        if ($token->test(Token::PUNCTUATION_TYPE, '(')) {
            $this->stream->next();
            $expr = $this->parseExpression();
            $this->stream->expect(Token::PUNCTUATION_TYPE, ')', 'An opened parenthesis is not properly closed');
            return $this->parsePostfixExpression($expr);
        }
        return $this->parsePrimaryExpression();
    }
    protected function parseConditionalExpression($expr)
    {
        while ($this->stream->current->test(Token::PUNCTUATION_TYPE, '?')) {
            $this->stream->next();
            if (!$this->stream->current->test(Token::PUNCTUATION_TYPE, ':')) {
                $expr2 = $this->parseExpression();
                if ($this->stream->current->test(Token::PUNCTUATION_TYPE, ':')) {
                    $this->stream->next();
                    $expr3 = $this->parseExpression();
                } else {
                    $expr3 = new Node\ConstantNode(null);
                }
            } else {
                $this->stream->next();
                $expr2 = $expr;
                $expr3 = $this->parseExpression();
            }
            $expr = new Node\ConditionalNode($expr, $expr2, $expr3);
        }
        return $expr;
    }
    public function parsePrimaryExpression()
    {
        $token = $this->stream->current;
        switch ($token->type) {
            case Token::NAME_TYPE:
                $this->stream->next();
                switch ($token->value) {
                    case 'true':
                    case 'TRUE':
                        return new Node\ConstantNode(true);
                    case 'false':
                    case 'FALSE':
                        return new Node\ConstantNode(false);
                    case 'null':
                    case 'NULL':
                        return new Node\ConstantNode(null);
                    default:
                        if ('(' === $this->stream->current->value) {
                            if (false === isset($this->functions[$token->value])) {
                                throw new SyntaxError(sprintf('The function "%s" does not exist.', $token->value), $token->cursor, $this->stream->getExpression(), $token->value, array_keys($this->functions));
                            }
                            $node = new Node\FunctionNode($token->value, $this->parseArguments());
                        } else {
                            if (!\in_array($token->value, $this->names, true)) {
                                throw new SyntaxError(sprintf('Variable "%s" is not valid.', $token->value), $token->cursor, $this->stream->getExpression(), $token->value, $this->names);
                            }
                            // is the name used in the compiled code different
                            // from the name used in the expression?
                            if (\is_int($name = array_search($token->value, $this->names))) {
                                $name = $token->value;
                            }
                            $node = new Node\NameNode($name);
                        }
                }
                break;
            case Token::NUMBER_TYPE:
            case Token::STRING_TYPE:
                $this->stream->next();
                return new Node\ConstantNode($token->value);
            default:
                if ($token->test(Token::PUNCTUATION_TYPE, '[')) {
                    $node = $this->parseArrayExpression();
                } elseif ($token->test(Token::PUNCTUATION_TYPE, '{')) {
                    $node = $this->parseHashExpression();
                } else {
                    throw new SyntaxError(sprintf('Unexpected token "%s" of value "%s".', $token->type, $token->value), $token->cursor, $this->stream->getExpression());
                }
        }
        return $this->parsePostfixExpression($node);
    }
    public function parseArrayExpression()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("parseArrayExpression") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/symfony/expression-language/Parser.php at line 173")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called parseArrayExpression:173@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/symfony/expression-language/Parser.php');
        die();
    }
    public function parseHashExpression()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("parseHashExpression") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/symfony/expression-language/Parser.php at line 192")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called parseHashExpression:192@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/symfony/expression-language/Parser.php');
        die();
    }
    public function parsePostfixExpression($node)
    {
        $token = $this->stream->current;
        while (Token::PUNCTUATION_TYPE == $token->type) {
            if ('.' === $token->value) {
                $this->stream->next();
                $token = $this->stream->current;
                $this->stream->next();
                if (Token::NAME_TYPE !== $token->type && (Token::OPERATOR_TYPE !== $token->type || !preg_match('/[a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]*/A', $token->value))) {
                    throw new SyntaxError('Expected name.', $token->cursor, $this->stream->getExpression());
                }
                $arg = new Node\ConstantNode($token->value, true);
                $arguments = new Node\ArgumentsNode();
                if ($this->stream->current->test(Token::PUNCTUATION_TYPE, '(')) {
                    $type = Node\GetAttrNode::METHOD_CALL;
                    foreach ($this->parseArguments()->nodes as $n) {
                        $arguments->addElement($n);
                    }
                } else {
                    $type = Node\GetAttrNode::PROPERTY_CALL;
                }
                $node = new Node\GetAttrNode($node, $arg, $arguments, $type);
            } elseif ('[' === $token->value) {
                $this->stream->next();
                $arg = $this->parseExpression();
                $this->stream->expect(Token::PUNCTUATION_TYPE, ']');
                $node = new Node\GetAttrNode($node, $arg, new Node\ArgumentsNode(), Node\GetAttrNode::ARRAY_CALL);
            } else {
                break;
            }
            $token = $this->stream->current;
        }
        return $node;
    }
    /**
     * Parses arguments.
     */
    public function parseArguments()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("parseArguments") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/symfony/expression-language/Parser.php at line 265")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called parseArguments:265@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/symfony/expression-language/Parser.php');
        die();
    }
}