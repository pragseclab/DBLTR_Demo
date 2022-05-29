<?php

/**
 * Parses a list of expressions delimited by a comma.
 */
namespace PhpMyAdmin\SqlParser\Components;

use PhpMyAdmin\SqlParser\Component;
use PhpMyAdmin\SqlParser\Parser;
use PhpMyAdmin\SqlParser\Token;
use PhpMyAdmin\SqlParser\TokensList;
/**
 * Parses a list of expressions delimited by a comma.
 *
 * @category   Keywords
 *
 * @license    https://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0+
 */
class ExpressionArray extends Component
{
    /**
     * @param Parser     $parser  the parser that serves as context
     * @param TokensList $list    the list of tokens that are being parsed
     * @param array      $options parameters for parsing
     *
     * @return Expression[]
     */
    public static function parse(Parser $parser, TokensList $list, array $options = array())
    {
        $ret = array();
        /**
         * The state of the parser.
         *
         * Below are the states of the parser.
         *
         *      0 ----------------------[ array ]---------------------> 1
         *
         *      1 ------------------------[ , ]------------------------> 0
         *      1 -----------------------[ else ]----------------------> (END)
         *
         * @var int
         */
        $state = 0;
        for (; $list->idx < $list->count; ++$list->idx) {
            /**
             * Token parsed at this moment.
             *
             * @var Token
             */
            $token = $list->tokens[$list->idx];
            // End of statement.
            if ($token->type === Token::TYPE_DELIMITER) {
                break;
            }
            // Skipping whitespaces and comments.
            if ($token->type === Token::TYPE_WHITESPACE || $token->type === Token::TYPE_COMMENT) {
                continue;
            }
            if ($token->type === Token::TYPE_KEYWORD && $token->flags & Token::FLAG_KEYWORD_RESERVED && ~$token->flags & Token::FLAG_KEYWORD_FUNCTION && $token->value !== 'DUAL' && $token->value !== 'NULL' && $token->value !== 'CASE') {
                // No keyword is expected.
                break;
            }
            if ($state === 0) {
                if ($token->type === Token::TYPE_KEYWORD && $token->value === 'CASE') {
                    $expr = CaseExpression::parse($parser, $list, $options);
                } else {
                    $expr = Expression::parse($parser, $list, $options);
                }
                if ($expr === null) {
                    break;
                }
                $ret[] = $expr;
                $state = 1;
            } elseif ($state === 1) {
                if ($token->value === ',') {
                    $state = 0;
                } else {
                    break;
                }
            }
        }
        if ($state === 0) {
            $parser->error('An expression was expected.', $list->tokens[$list->idx]);
        }
        --$list->idx;
        return $ret;
    }
    /**
     * @param ExpressionArray[] $component the component to be built
     * @param array             $options   parameters for building
     *
     * @return string
     */
    public static function build($component, array $options = array())
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("build") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/vendor/phpmyadmin/sql-parser/src/Components/ExpressionArray.php at line 120")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called build:120@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/vendor/phpmyadmin/sql-parser/src/Components/ExpressionArray.php');
        die();
    }
}