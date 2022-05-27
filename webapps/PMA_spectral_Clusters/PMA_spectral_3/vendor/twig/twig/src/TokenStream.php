<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 * (c) Armin Ronacher
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Twig;

use Twig\Error\SyntaxError;
/**
 * Represents a token stream.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
final class TokenStream
{
    private $tokens;
    private $current = 0;
    private $source;
    public function __construct(array $tokens, Source $source = null)
    {
        $this->tokens = $tokens;
        $this->source = $source ?: new Source('', '');
    }
    public function __toString()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("__toString") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/TokenStream.php at line 32")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called __toString:32@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/TokenStream.php');
        die();
    }
    public function injectTokens(array $tokens)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("injectTokens") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/TokenStream.php at line 36")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called injectTokens:36@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/TokenStream.php');
        die();
    }
    /**
     * Sets the pointer to the next token and returns the old one.
     */
    public function next() : Token
    {
        if (!isset($this->tokens[++$this->current])) {
            throw new SyntaxError('Unexpected end of template.', $this->tokens[$this->current - 1]->getLine(), $this->source);
        }
        return $this->tokens[$this->current - 1];
    }
    /**
     * Tests a token, sets the pointer to the next one and returns it or throws a syntax error.
     *
     * @return Token|null The next token if the condition is true, null otherwise
     */
    public function nextIf($primary, $secondary = null)
    {
        if ($this->tokens[$this->current]->test($primary, $secondary)) {
            return $this->next();
        }
    }
    /**
     * Tests a token and returns it or throws a syntax error.
     */
    public function expect($type, $value = null, string $message = null) : Token
    {
        $token = $this->tokens[$this->current];
        if (!$token->test($type, $value)) {
            $line = $token->getLine();
            throw new SyntaxError(sprintf('%sUnexpected token "%s"%s ("%s" expected%s).', $message ? $message . '. ' : '', Token::typeToEnglish($token->getType()), $token->getValue() ? sprintf(' of value "%s"', $token->getValue()) : '', Token::typeToEnglish($type), $value ? sprintf(' with value "%s"', $value) : ''), $line, $this->source);
        }
        $this->next();
        return $token;
    }
    /**
     * Looks at the next token.
     */
    public function look(int $number = 1) : Token
    {
        if (!isset($this->tokens[$this->current + $number])) {
            throw new SyntaxError('Unexpected end of template.', $this->tokens[$this->current + $number - 1]->getLine(), $this->source);
        }
        return $this->tokens[$this->current + $number];
    }
    /**
     * Tests the current token.
     */
    public function test($primary, $secondary = null) : bool
    {
        return $this->tokens[$this->current]->test($primary, $secondary);
    }
    /**
     * Checks if end of stream was reached.
     */
    public function isEOF() : bool
    {
        return -1 === $this->tokens[$this->current]->getType();
    }
    public function getCurrent() : Token
    {
        return $this->tokens[$this->current];
    }
    /**
     * Gets the source associated with this stream.
     *
     * @internal
     */
    public function getSourceContext() : Source
    {
        return $this->source;
    }
}
class_alias('Twig\\TokenStream', 'Twig_TokenStream');