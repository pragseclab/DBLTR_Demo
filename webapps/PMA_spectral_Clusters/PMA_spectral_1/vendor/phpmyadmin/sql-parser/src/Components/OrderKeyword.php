<?php

/**
 * `ORDER BY` keyword parser.
 */
declare (strict_types=1);
namespace PhpMyAdmin\SqlParser\Components;

use PhpMyAdmin\SqlParser\Component;
use PhpMyAdmin\SqlParser\Parser;
use PhpMyAdmin\SqlParser\Token;
use PhpMyAdmin\SqlParser\TokensList;
use function implode;
use function is_array;
/**
 * `ORDER BY` keyword parser.
 */
class OrderKeyword extends Component
{
    /**
     * The expression that is used for ordering.
     *
     * @var Expression
     */
    public $expr;
    /**
     * The order type.
     *
     * @var string
     */
    public $type;
    /**
     * @param Expression $expr the expression that we are sorting by
     * @param string     $type the sorting type
     */
    public function __construct($expr = null, $type = 'ASC')
    {
        $this->expr = $expr;
        $this->type = $type;
    }
    /**
     * @param Parser     $parser  the parser that serves as context
     * @param TokensList $list    the list of tokens that are being parsed
     * @param array      $options parameters for parsing
     *
     * @return OrderKeyword[]
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
         *      0 --------------------[ expression ]-------------------> 1
         *
         *      1 ------------------------[ , ]------------------------> 0
         *      1 -------------------[ ASC / DESC ]--------------------> 1
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
            if ($state === 0) {
                $expr->expr = Expression::parse($parser, $list);
                $state = 1;
            } elseif ($state === 1) {
                if ($token->type === Token::TYPE_KEYWORD && ($token->keyword === 'ASC' || $token->keyword === 'DESC')) {
                    $expr->type = $token->keyword;
                } elseif ($token->type === Token::TYPE_OPERATOR && $token->value === ',') {
                    if (!empty($expr->expr)) {
                        $ret[] = $expr;
                    }
                    $expr = new static();
                    $state = 0;
                } else {
                    break;
                }
            }
        }
        // Last iteration was not processed.
        if (!empty($expr->expr)) {
            $ret[] = $expr;
        }
        --$list->idx;
        return $ret;
    }
    /**
     * @param OrderKeyword|OrderKeyword[] $component the component to be built
     * @param array                       $options   parameters for building
     *
     * @return string
     */
    public static function build($component, array $options = array())
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("build") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/vendor/phpmyadmin/sql-parser/src/Components/OrderKeyword.php at line 112")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called build:112@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/vendor/phpmyadmin/sql-parser/src/Components/OrderKeyword.php');
        die();
    }
}