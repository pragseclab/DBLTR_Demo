<?php

/**
 * `SET` keyword parser.
 */
declare (strict_types=1);
namespace PhpMyAdmin\SqlParser\Components;

use PhpMyAdmin\SqlParser\Component;
use PhpMyAdmin\SqlParser\Parser;
use PhpMyAdmin\SqlParser\Token;
use PhpMyAdmin\SqlParser\TokensList;
use function implode;
use function is_array;
use function trim;
/**
 * `SET` keyword parser.
 */
class SetOperation extends Component
{
    /**
     * The name of the column that is being updated.
     *
     * @var string
     */
    public $column;
    /**
     * The new value.
     *
     * @var string
     */
    public $value;
    /**
     * @param string $column Field's name..
     * @param string $value  new value
     */
    public function __construct($column = '', $value = '')
    {
        $this->column = $column;
        $this->value = $value;
    }
    /**
     * @param Parser     $parser  the parser that serves as context
     * @param TokensList $list    the list of tokens that are being parsed
     * @param array      $options parameters for parsing
     *
     * @return SetOperation[]
     */
    public static function parse(Parser $parser, TokensList $list, array $options = array())
    {
        $ret = [];
        $expr = new static();
        /**
         * The state of the parser.
         *
         * Below are the states of the parser.
         *
         *      0 ---------------------[ col_name ]--------------------> 0
         *      0 ------------------------[ = ]------------------------> 1
         *      1 -----------------------[ value ]---------------------> 1
         *      1 ------------------------[ , ]------------------------> 0
         *
         * @var int
         */
        $state = 0;
        /**
         * Token when the parser has seen the latest comma
         *
         * @var Token
         */
        $commaLastSeenAt = null;
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
            // No keyword is expected.
            if ($token->type === Token::TYPE_KEYWORD && $token->flags & Token::FLAG_KEYWORD_RESERVED && $state === 0) {
                break;
            }
            if ($state === 0) {
                if ($token->token === '=') {
                    $state = 1;
                } elseif ($token->value !== ',') {
                    $expr->column .= $token->token;
                } elseif ($token->value === ',') {
                    $commaLastSeenAt = $token;
                }
            } elseif ($state === 1) {
                $tmp = Expression::parse($parser, $list, ['breakOnAlias' => true]);
                if ($tmp === null) {
                    $parser->error('Missing expression.', $token);
                    break;
                }
                $expr->column = trim($expr->column);
                $expr->value = $tmp->expr;
                $ret[] = $expr;
                $expr = new static();
                $state = 0;
                $commaLastSeenAt = null;
            }
        }
        --$list->idx;
        // We saw a comma, but didn't see a column-value pair after it
        if ($commaLastSeenAt !== null) {
            $parser->error('Unexpected token.', $commaLastSeenAt);
        }
        return $ret;
    }
    /**
     * @param SetOperation|SetOperation[] $component the component to be built
     * @param array                       $options   parameters for building
     *
     * @return string
     */
    public static function build($component, array $options = array())
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("build") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/vendor/phpmyadmin/sql-parser/src/Components/SetOperation.php at line 128")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called build:128@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/vendor/phpmyadmin/sql-parser/src/Components/SetOperation.php');
        die();
    }
}