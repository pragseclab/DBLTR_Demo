<?php

/**
 * `ALTER` statement.
 */
declare (strict_types=1);
namespace PhpMyAdmin\SqlParser\Statements;

use PhpMyAdmin\SqlParser\Components\AlterOperation;
use PhpMyAdmin\SqlParser\Components\Expression;
use PhpMyAdmin\SqlParser\Components\OptionsArray;
use PhpMyAdmin\SqlParser\Parser;
use PhpMyAdmin\SqlParser\Statement;
use PhpMyAdmin\SqlParser\Token;
use PhpMyAdmin\SqlParser\TokensList;
use function implode;
/**
 * `ALTER` statement.
 */
class AlterStatement extends Statement
{
    /**
     * Table affected.
     *
     * @var Expression
     */
    public $table;
    /**
     * Column affected by this statement.
     *
     * @var AlterOperation[]
     */
    public $altered = array();
    /**
     * Options of this statement.
     *
     * @var array
     */
    public static $OPTIONS = array('ONLINE' => 1, 'OFFLINE' => 1, 'IGNORE' => 2, 'DATABASE' => 3, 'EVENT' => 3, 'FUNCTION' => 3, 'PROCEDURE' => 3, 'SERVER' => 3, 'TABLE' => 3, 'TABLESPACE' => 3, 'VIEW' => 3);
    /**
     * @param Parser     $parser the instance that requests parsing
     * @param TokensList $list   the list of tokens to be parsed
     */
    public function parse(Parser $parser, TokensList $list)
    {
        ++$list->idx;
        // Skipping `ALTER`.
        $this->options = OptionsArray::parse($parser, $list, static::$OPTIONS);
        ++$list->idx;
        // Parsing affected table.
        $this->table = Expression::parse($parser, $list, ['parseField' => 'table', 'breakOnAlias' => true]);
        ++$list->idx;
        // Skipping field.
        /**
         * The state of the parser.
         *
         * Below are the states of the parser.
         *
         *      0 -----------------[ alter operation ]-----------------> 1
         *
         *      1 -------------------------[ , ]-----------------------> 0
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
                $options = [];
                if ($this->options->has('DATABASE')) {
                    $options = AlterOperation::$DB_OPTIONS;
                } elseif ($this->options->has('TABLE')) {
                    $options = AlterOperation::$TABLE_OPTIONS;
                } elseif ($this->options->has('VIEW')) {
                    $options = AlterOperation::$VIEW_OPTIONS;
                }
                $this->altered[] = AlterOperation::parse($parser, $list, $options);
                $state = 1;
            } elseif ($state === 1) {
                if ($token->type === Token::TYPE_OPERATOR && $token->value === ',') {
                    $state = 0;
                }
            }
        }
    }
    /**
     * @return string
     */
    public function build()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("build") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/vendor/phpmyadmin/sql-parser/src/Statements/AlterStatement.php at line 104")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called build:104@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/vendor/phpmyadmin/sql-parser/src/Statements/AlterStatement.php');
        die();
    }
}